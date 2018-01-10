<?php

namespace App\Repositories\Eloquent\Traits;

use App\Models\Post;
use Carbon\Carbon;

/**
 * Trait FieldsHandler
 * @package App\Repositories\Eloquent\Traits
 */
trait FieldsHandler
{
    /**
     * @param $value
     * @return \Carbon\Carbon
     */
    public function handlePublishedAt($value)
    {
        return empty($value) ? Carbon::now() : Carbon::createFromTimestamp(strtotime($value));
    }

    /**
     * @param $value
     * @return int
     */
    public function handleIsDraft($value)
    {
        return empty($value) ? Post::IS_NOT_DRAFT : Post::IS_DRAFT;
    }
}