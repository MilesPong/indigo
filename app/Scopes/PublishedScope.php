<?php

namespace App\Scopes;

use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

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
        $builder->where('published_at', '<=', Carbon::now()->toDateTimeString())
            ->where('is_draft', '=', Post::IS_NOT_DRAFT);
    }
}