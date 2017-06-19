<?php

return [
    'counter' => [
        'timeout' => 3600, // 1h
        'key' => 'post_viewed',
        'cache_key' => 'post_viewed_count:',
        'strict_mode' => true,
    ],
    'analytics' => [
        'google_trace_id' => env('GOOGLE_ANALYTICS_ID'),
    ]
];
