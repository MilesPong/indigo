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
    ]
];