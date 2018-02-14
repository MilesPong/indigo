<?php

namespace App\Repositories\Eloquent\Traits;

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
     * @return bool
     */
    public function handleIsDraft($value)
    {
        // TODO when switch to 'publish', this attribute is not contained in the post data. Should be fix in
        // frontend and update this method.
        return !empty($value);
    }

    /**
     * @param array $attributes
     * @return array
     */
    public function handle(array $attributes)
    {
        foreach ($attributes as $field => &$value) {
            if (method_exists($this, $method = 'handle' . studly_case($field))) {
                // Note that the parameters for call_user_func() are not passed by reference.
                $value = call_user_func([$this, $method], $value);
            }
        }

        return $attributes;
    }
}