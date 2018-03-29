<?php

return [
    'counter' => [
        /*
        |--------------------------------------------------------------------------
        | Default Cache Store of Counter
        |--------------------------------------------------------------------------
        |
        | With referenced to cache.php
        | Set "null" to use cache's default store.
        |
        */
        'cache_store' => env('COUNTER_DEFAULT_STORE', null)
    ],
    'posts' => [
        'per_page' => 5,
    ],
    'analytics' => [
        'google_trace_id' => env('GOOGLE_ANALYTICS_ID'),
    ],
    'log' => [
        'visitor' => env('ENABLE_VISITOR_LOG', false),
    ],
    'comment' => [
        'driver' => env('COMMENT_DRIVER', 'null'), // Supported: "null", "disqus"
        'disqus' => [
            'short_name' => env('DISQUS_SHORT_NAME'),
        ]
    ],
    'repository' => [
        'pagination' => [
            'per_page' => env('REPOSITORY_DEFAULT_PER_PAGE', 15)
        ]
    ],
    'supported_locales' => [
        'en' => 'English',
        'zh-CN' => '简体中文',
        'zh-HK' => '繁體中文（香港）'
    ],
    'github_webhook_secret' => env('GITHUB_WEBHOOK_SECRET')
];