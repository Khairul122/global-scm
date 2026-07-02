# Development Guidelines (Do's and Don'ts)

Guidelines for maintaining and extending the Global Supply Chain Risk Intelligence Platform.

## Do's

### 1. Architecture & Services
- **Do** isolate external API interactions within dedicated client classes under `app/Integrations/` (e.g. `WorldBankClient`).
- **Do** place core business logic (such as Lexicon Sentiment Parsing and Risk Calculation) in dedicated Service classes under `app/Services/`. Keep controllers thin.
- **Do** implement a database and memory caching wrapper (Cache-Aside pattern) for external APIs.

### 2. UI / UX & Styling
- **Do** use Bootstrap 5 for responsiveness and styling. Incorporate custom vanilla CSS in `resources/css/app.css` for a premium dark, sleek, glassmorphic theme.
- **Do** include skeleton loaders for asynchronous API-based cards to ensure page loads are fast (target under 3 seconds).
- **Do** ensure all colored indicators conform to WCAG AA color contrast ratios (e.g. text color must remain readable on green/yellow/red risk badges).

### 3. Database & Seeding
- **Do** write migrations that are compatible with both SQLite (local testing) and MySQL 8 (production). Avoid complex DB-specific dialects or raw DB functions unless wrapped.
- **Do** provide seeders for the 20 primary countries, default risk weights, and initial lexicon dictionaries (`positive_words`, `negative_words`) so the application is fully functional out-of-the-box.

### 4. Security & Error Handling
- **Do** validate all incoming HTTP data via Form Requests.
- **Do** catch external API connection failures, timeouts, and quota limits, showing user-friendly warning messages and serving cached data instead of throwing raw stack traces.

---

## Don't's

- **Don't** perform external API requests inside Blade templates or loops.
- **Don't** hardcode third-party API keys (e.g. GNews, ExchangeRate) inside the codebase. Read them from `.env` and provide mock fallback values.
- **Don't** allow N+1 queries. Eager-load relations like `sentimentResult` when querying `news_cache` or `components` when querying `risk_scores`.
- **Don't** allow users to add more than 20 countries to their Watchlist. Enforce this via model validation/policy.
- **Don't** skip confirmation dialogs for destructive actions in the Admin dashboard.
