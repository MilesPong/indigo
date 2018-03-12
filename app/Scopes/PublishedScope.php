<?php

namespace App\Scopes;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Indigo\Contracts\HasPublishedTime;
use Indigo\Models\Article;

/**
 * Class PublishedScope
 * @package App\Scopes
 */
class PublishedScope implements Scope
{
    /**
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @param \Illuminate\Database\Eloquent\Model $model
     * @return void
     */
    public function apply(Builder $builder, Model $model)
    {
        if ($model instanceof HasPublishedTime) {
            $builder = $builder->where('published_at', '<=', Carbon::now()->toDateTimeString());
        }

        $builder->where('is_draft', '=', Article::IS_NOT_DRAFT);
    }
}