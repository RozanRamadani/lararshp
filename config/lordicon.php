<?php

return [
    // If true, only use icons listed in 'allowed_icons' (useful for free Lordicon accounts)
    // By default do not force-only free icons. Set LORDICON_USE_FREE_ONLY=true in .env to re-enable.
    'use_free_only' => env('LORDICON_USE_FREE_ONLY', false),

    // List of Lordicon semantic names that are safe to use with a free account.
    // Add or remove icons here if you have a paid plan and want to enable more.
    'allowed_icons' => [
        'plus', 'edit', 'trash', 'delete', 'check', 'x', 'search', 'arrow-left', 'eye',
        'pet', 'dog', 'cat', 'owner', 'vet', 'clinic', 'medical', 'stethoscope', 'medicine', 'first-aid',
        'statistics', 'activity', 'calendar', 'report', 'list', 'category', 'puzzle',
        'users', 'user-check', 'shield', 'home', 'alert-circle'
    ],
    // Optional: list icons you consider paid and want to always render via Freepik fallback
    // e.g. ['scalpel', 'lab', 'xray', 'grooming', 'oncology']
    'paid_icons' => env('LORDICON_PAID_ICONS', []),
];
