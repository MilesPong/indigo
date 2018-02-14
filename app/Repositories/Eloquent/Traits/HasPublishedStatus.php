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
     * @see \App\Repositories\Contracts\Helpers\HasPublishedStatus::ignorePublishedStatusMode()
     * @return $this
     */
    public function ignorePublishedStatusMode()
    {
        $this->model = $this->model->withoutGlobalScope(PublishedScope::class);

        return $this;
    }
}