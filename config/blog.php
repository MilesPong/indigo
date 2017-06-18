<?php

return [
    'counter' => [
        'timeout' => 3600, // 1h
        'key' => 'post_viewed',
        'cache_key' => 'post_',
    ],
    'analytics' => [
        'google_trace_id' => env('GOOGLE_ANALYTICS_ID'),
    ]
];