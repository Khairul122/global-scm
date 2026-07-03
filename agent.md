# Development Guidelines (Do's and Don'ts)

Guidelines for maintaining and extending the Global Supply Chain Risk Intelligence Platform.

## Do's

### 1. Architecture & Services
- **Do** isolate external API interactions within dedicated client classes under `app/Integrations/` (e.g. `WorldBankClient`).
- **Do** place core business logic (such as Lexicon Sentiment Parsing and Risk Calculation) in dedicated Service classes under `app/Services/`. Keep controllers thin.
- **Do** implement a database and memory caching wrapper (Cache-Aside pattern) for external APIs.

### 2. UI / UX & Styling
- **Do** use Tailwind CSS 4 (CSS-first `@theme` config in `resources/css/app.css`) with native utility classes directly in Blade markup. Do not reintroduce Bootstrap or a Bootstrap-class compatibility shim — a prior attempt at emulating `.row`/`.col-*`/`.btn`/etc. via custom CSS caused inconsistent, broken layouts on nested grids and JS-injected cards (admin tabs, watchlist grid). Write each page's markup with real Tailwind utilities (`grid grid-cols-*`, `flex`, etc.) instead.
- **Do** use Alpine.js (already bundled via `resources/js/app.js`) for client-side interactivity (tabs, dropdowns, mobile drawer). Always pair `x-show` with `x-cloak` (and the `[x-cloak]{display:none!important}` base rule already in `app.css`) to avoid a flash of all conditional panels before Alpine initializes.
- **Do** follow the current design system: light background (`--color-background:#F4F7FB`), white skeuomorphic cards (`.skeuo-card` — soft dual box-shadow, not flat/dark glassmorphism), tactile buttons (`.btn-skeuo` / `.btn-skeuo-outline` with pressed/inset states), teal/blue accent palette (`--color-primary:#0F766E`, `--color-accent:#0369A1`).
- **Do** include skeleton loaders for asynchronous API-based cards to ensure page loads are fast (target under 3 seconds).
- **Do** ensure all colored indicators conform to WCAG AA color contrast ratios (e.g. text color must remain readable on green/yellow/red risk badges). Risk badges (`.risk-low/.risk-medium/.risk-high`) must always pair color with an icon and text label, never color alone.
- **Do** gate all dashboard/data pages (Dashboard, Cuaca, Valuta, Pelabuhan, Berita, Analitik, Komparasi, Watchlist, Admin) behind the `auth` middleware (see `routes/web.php`). Only the landing page, login, and register are public, using the separate `layouts/guest.blade.php` shell (no sidebar).

### 3. Database & Seeding
- **Do** write migrations that are compatible with both SQLite (local testing) and MySQL 8 (production). Avoid complex DB-specific dialects or raw DB functions unless wrapped.
- **Do** provide seeders for the 20 primary countries, default risk weights, and initial lexicon dictionaries (`positive_words`, `negative_words`) so the application is fully functional out-of-the-box.

### 4. Security & Error Handling
- **Do** validate all incoming HTTP data via Form Requests.
- **Do** catch external API connection failures, timeouts, and quota limits, showing user-friendly warning messages and serving cached data instead of throwing raw stack traces.

---

## Don't's

- **Don't** perform external API requests inside Blade templates or loops.
- **Don't** hardcode third-party API keys (e.g. GNews, ExchangeRate) inside the codebase. Read them from `.env` (see `GNEWS_API_KEY`, `EXCHANGERATE_API_KEY` in `.env.example`).
- **Don't** fabricate mock/placeholder data when an external API key is missing or a request fails (e.g. `GNewsClient` used to silently serve fake `example.com` articles — this was removed). Return an empty result and let the UI show an honest empty state instead.
- **Don't** allow N+1 queries. Eager-load relations like `sentimentResult` when querying `news_cache` or `components` when querying `risk_scores`.
- **Don't** allow users to add more than 20 countries to their Watchlist. Enforce this via model validation/policy.
- **Don't** skip confirmation dialogs for destructive actions in the Admin dashboard.
