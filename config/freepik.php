<?php

return [
    // API key for Freepik (set in .env as FREEPIK_API_KEY)
    'api_key' => env('FPSXcc88a53f48ef56ef9768a5691cd1649a', ''),
    // Search endpoint - some Freepik integrations may provide a private endpoint.
    // You can override this in .env if your Freepik partner/integration gives a specific URL.
    'search_endpoint' => env('FREEPIK_SEARCH_ENDPOINT', 'https://api.freepik.com/v1/search'),
];
