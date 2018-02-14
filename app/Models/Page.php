<?php

namespace App\Models;

use Indigo\Models\Article as ArticleModel;

/**
 * Class Page
 * @package App\Models
 */
class Page extends ArticleModel
{
    /**
     * @var array
     */
    protected $fillable = [
        'title',
        'description',
        'slug',
        'is_draft',
        'title',
        'title',
    ];
    /**
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * @return mixed
     */
    public function getRawContentAttribute()
    {
        return $this->content()->getResults()->body;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function content()
    {
        return $this->belongsTo(Content::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}