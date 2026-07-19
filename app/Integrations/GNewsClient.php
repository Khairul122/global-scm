<?php

namespace App\Integrations;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GNewsClient
{
    public function getNews(string $category = 'logistics', ?string $countryName = null): array
    {
        $apiKey = env('GNEWS_API_KEY');

        if (!$apiKey) {
            Log::info('GNEWS_API_KEY not set, skipping news fetch.');
            return [];
        }

        try {
            // GNews combines bare space-separated words with AND, not OR, so plain
            // keyword lists like "logistics freight cargo shipping" require every
            // single word to appear in the same article and almost always match
            // nothing. Group topic synonyms with OR instead.
            $topicQuery = match ($category) {
                'shipping' => '(shipping OR logistics OR port OR cargo)',
                'trade' => '("international trade" OR exports OR imports OR tariff)',
                'economy' => '(economy OR inflation OR gdp OR recession OR currency)',
                default => '("supply chain" OR logistics OR freight OR cargo OR shipping)'
            };

            $query = $countryName ? "{$topicQuery} AND {$countryName}" : $topicQuery;

            $response = Http::timeout(10)
                ->retry(2, 800)
                ->get("https://gnews.io/api/v4/search", [
                    'q' => $query,
                    'lang' => 'en',
                    'apikey' => $apiKey,
                    'max' => 10
                ]);

            if ($response->successful()) {
                $data = $response->json();
                $articles = $data['articles'] ?? [];

                $result = [];
                foreach ($articles as $art) {
                    $result[] = [
                        'title' => $art['title'] ?? '',
                        'description' => $art['description'] ?? '',
                        'url' => $art['url'] ?? '',
                        'image_url' => $art['image'] ?? null,
                        'published_at' => $art['publishedAt'] ?? now()->toIso8601String(),
                        'source' => $art['source']['name'] ?? 'GNews'
                    ];
                }
                return $result;
            }

            Log::warning("GNews API responded with status {$response->status()} for query '{$query}'.");
        } catch (\Exception $e) {
            Log::warning("GNews API error: " . $e->getMessage());
        }

        return [];
    }
}
