<?php

namespace App\Integrations;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GNewsClient
{
    public function getNews(string $category = 'logistics', ?string $countryCode = null): array
    {
        $apiKey = env('GNEWS_API_KEY');
        
        // If API key is available, query GNews
        if ($apiKey) {
            try {
                // Map category to search query terms
                $query = match ($category) {
                    'shipping' => 'shipping logistics port cargo',
                    'trade' => 'international trade exports imports tariff',
                    'economy' => 'economic inflation gdp recession currency',
                    default => 'supply chain logistics freight cargo shipping'
                };

                if ($countryCode) {
                    $query .= " " . strtolower($countryCode);
                }

                $response = Http::timeout(5)
                    ->retry(1, 100)
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
                            'published_at' => $art['publishedAt'] ?? now()->toIso8601String(),
                            'source' => $art['source']['name'] ?? 'GNews'
                        ];
                    }
                    if (!empty($result)) {
                        return $result;
                    }
                }
            } catch (\Exception $e) {
                Log::warning("GNews API error, falling back to mock news: " . $e->getMessage());
            }
        }

        // Offline / Mock Fallback news articles related to categories & countries
        return $this->getMockNews($category, $countryCode);
    }

    protected function getMockNews(string $category, ?string $countryCode): array
    {
        $countryName = $countryCode ? strtoupper($countryCode) : 'Global';

        $mockArticles = [
            'logistics' => [
                [
                    'title' => "Supply Chain Congestion Alerts Issued for major {$countryName} Transit Routes",
                    'description' => "Severe logistics delays are emerging in critical trade routes, causing shippers to seek alternative corridors. Port wait times are increasing steadily due to labor adjustments and routing changes.",
                    'url' => "https://example.com/logistics/supply-chain-congestion-{$countryName}-" . uniqid(),
                    'published_at' => now()->subHours(2)->toIso8601String(),
                    'source' => 'Logistics Intelligence'
                ],
                [
                    'title' => "Freight Rates Rise Amid Capacity Constraints in {$countryName} Markets",
                    'description' => "Air and ocean freight rates have jumped by 12% in the current quarter. Driver shortages and fuel surcharges continue to challenge regional distribution hubs.",
                    'url' => "https://example.com/logistics/freight-rates-rise-{$countryName}-" . uniqid(),
                    'published_at' => now()->subHours(8)->toIso8601String(),
                    'source' => 'Ocean & Air Weekly'
                ],
                [
                    'title' => "Warehouse Vacancy Drops, Straining Storage Networks",
                    'description' => "A spike in inventory buffers has led to record-low warehouse vacancies in {$countryName}. Logistics managers warn of price surges for short-term leasing.",
                    'url' => "https://example.com/logistics/warehouse-vacancy-{$countryName}-" . uniqid(),
                    'published_at' => now()->subDays(1)->toIso8601String(),
                    'source' => 'Global Logistics Review'
                ]
            ],
            'shipping' => [
                [
                    'title' => "New Maritime Regulations Shift {$countryName} Port Operations",
                    'description' => "Port authorities in {$countryName} have introduced strict decarbonization measures, causing minor delays for inbound vessels. Cargo carriers are adjusting cruising speeds to comply.",
                    'url' => "https://example.com/shipping/maritime-regulations-{$countryName}-" . uniqid(),
                    'published_at' => now()->subHours(4)->toIso8601String(),
                    'source' => 'Maritime Gazette'
                ],
                [
                    'title' => "Major Shipping Carrier Announces Schedule Updates For {$countryName} Ports",
                    'description' => "To optimize vessel utilization, a leading shipping line has revised its port calls. Feeder network updates will impact transit times for cargo exports.",
                    'url' => "https://example.com/shipping/schedule-updates-{$countryName}-" . uniqid(),
                    'published_at' => now()->subHours(12)->toIso8601String(),
                    'source' => 'Shipping Daily'
                ]
            ],
            'trade' => [
                [
                    'title' => "{$countryName} Trade Balance Reflects Growing Demand for Capital Goods",
                    'description' => "The latest export-import statement reveals a surplus in capital goods trade, highlighting manufacturing growth. Economists project a stable trend for the upcoming quarter.",
                    'url' => "https://example.com/trade/trade-balance-{$countryName}-" . uniqid(),
                    'published_at' => now()->subHours(6)->toIso8601String(),
                    'source' => 'Trade Policy Journal'
                ],
                [
                    'title' => "Tariff Negotiations Open Between {$countryName} and Key Trading Partners",
                    'description' => "Bilateral trade talks have commenced, focusing on electronic component duties. Success could reduce supply chain friction for tech manufacturers.",
                    'url' => "https://example.com/trade/tariff-negotiations-{$countryName}-" . uniqid(),
                    'published_at' => now()->subDays(2)->toIso8601String(),
                    'source' => 'Bilateral Trade News'
                ]
            ],
            'economy' => [
                [
                    'title' => "Central Bank in {$countryName} Adjusts Interest Rates to Combat Inflation",
                    'description' => "To stabilize consumer prices, the monetary policy committee raised benchmark interest rates by 25 basis points. Analysts foresee minor borrowing costs increase for importers.",
                    'url' => "https://example.com/economy/central-bank-interest-{$countryName}-" . uniqid(),
                    'published_at' => now()->subHours(1)->toIso8601String(),
                    'source' => 'Financial Chronicle'
                ],
                [
                    'title' => "Currency Volatility Impacts {$countryName} Trade Invoicing",
                    'description' => "Exchange rate movements have prompted local importers to rewrite supplier contracts. Hedging strategies are widely implemented to limit currency risk exposure.",
                    'url' => "https://example.com/economy/currency-volatility-{$countryName}-" . uniqid(),
                    'published_at' => now()->subHours(18)->toIso8601String(),
                    'source' => 'FX Market Monitor'
                ]
            ]
        ];

        return $mockArticles[$category] ?? $mockArticles['logistics'];
    }
}
