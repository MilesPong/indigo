<?php

namespace App\Services;

/**
 * Class CacheHelper
 * @package App\Services
 */
class CacheHelper
{
    /**
     * Cache keys map
     */
    const KEYS_MAP = [
        'paginate' => [
            'tag_name' => 'paginate',
            'key_format' => '%s:%s-%s'
        ],
        'find' => [
            'tag_name' => 'find',
            'key_format' => '%s:%s'
        ],
        'all' => [
            'tag_name' => 'all',
            'key_format' => '%s:%s'
        ],
    ];
}