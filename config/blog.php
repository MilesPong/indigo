<?php

return [
    'counter' => [
        'strict_mode' => env('COUNT_STRICT_MODE', false),
        'cache_key' => 'post_viewed_count:',
        // require strict_mode to be set
        'timeout' => 3600, // 1h
        'key' => 'post_viewed',
    ],
    'analytics' => [
        'google_trace_id' => env('GOOGLE_ANALYTICS_ID'),
    ]
];
