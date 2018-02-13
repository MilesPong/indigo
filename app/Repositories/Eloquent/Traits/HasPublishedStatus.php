<?php

namespace App\Repositories\Eloquent\Traits;

use App\Scopes\PublishedScope;

/**
 * Trait HasPublishedStatus
 * @package App\Repositories\Eloquent\Traits
 */
trait HasPublishedStatus
{
    /**
     * @return $this
     */
    public function ignorePublishedStatusMode()
    {
        $this->model = $this->model->withoutGlobalScope(PublishedScope::class);

        return $this;
    }
}