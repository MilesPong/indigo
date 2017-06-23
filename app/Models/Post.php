<?php

namespace App\Models;

use App\Presenters\PostPresenter;
use App\Scopes\PublishedScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laracasts\Presenter\PresentableTrait;

/**
 * Class Post
 * @package App\Models
 */
class Post extends Model
{
    use PresentableTrait, SoftDeletes;

    /**
     * Is draft status
     */
    const IS_DRAFT = 1;

    /**
     * Is not draft status
     */
    const IS_NOT_DRAFT = 0;

    /**
     * @var string
     */
    protected $presenter = PostPresenter::class;

    /**
     * @var array
     */
    protected $fillable = [
        'category_id',
        'title',
        'slug',
        'description',
        'content',
        'published_at',
        'is_draft',
        'excerpt',
        'feature_img'
    ];

    /**
     * @var array
     */
    protected $dates = ['published_at', 'deleted_at'];

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new PublishedScope);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function content()
    {
        return $this->belongsTo(Content::class);
    }

    /**
     * @param $name
     * @return mixed
     */
    public function getConst($name)
    {
        return constant("self::{$name}");
    }
}
