<?php

return [
    'counter' => [
        'strict_mode' => env('COUNT_STRICT_MODE', false),
        'cache_key' => 'post_viewed_count:',
        // require strict_mode to be set
        'timeout' => 3600, // 1h
        'key' => 'post_viewed',
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
    ]
];
