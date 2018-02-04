<?php

namespace App\Models;

use App\Indigo\Contracts\Viewable as ViewableContract;
use App\Presenters\PostPresenter;
use App\Scopes\PublishedScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Indigo\Contracts\Markdownable;
use Indigo\Tools\MarkDownParser;
use Laracasts\Presenter\PresentableTrait;

/**
 * Class Post
 * @package App\Models
 */
class Post extends Model implements Markdownable, ViewableContract
{
    use PresentableTrait, SoftDeletes, Viewable;
    /**
     * Is draft status
     */
    const IS_DRAFT = 1;
    /**
     * Is not draft status
     */
    const IS_NOT_DRAFT = 0;
    /**
     * Cache key prefix of post's content
     */
    const CONTENT_CACHE_KEY_PREFIX = 'contents:';
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
        'content_id',
        'published_at',
        'is_draft',
        'feature_img'
    ];
    /**
     * @var array
     */
    protected $dates = ['published_at', 'deleted_at'];
    /**
     * @var array
     */
    protected $casts = [
        'is_draft' => 'boolean'
    ];

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
     * @param $name
     * @return mixed
     */
    public function getConst($name)
    {
        return constant("self::{$name}");
    }

    /**
     * @return string
     */
    public function getContentAttribute()
    {
        // TODO cache
        return MarkDownParser::md2html($this);
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param mixed $published
     * @param array $columns
     * @return \Illuminate\Database\Query\Builder
     */
    public function scopePrevious($query, $published, $columns = ['*'])
    {
        return $query->select($columns)->where('published_at', '<',
            $this->parsePublishTime($published))->latest('published_at');
    }

    /**
     * @param $value
     * @return string
     */
    private function parsePublishTime($value)
    {
        return $value instanceof self ? $this->fromDateTime($value->getAttribute('published_at')) : $value;
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param mixed $published
     * @param array $columns
     * @return \Illuminate\Database\Query\Builder
     */
    public function scopeNext($query, $published, $columns = ['*'])
    {
        return $query->select($columns)->where('published_at', '>',
            $this->parsePublishTime($published))->oldest('published_at');
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int $limit
     * @param array $columns
     * @return \Illuminate\Database\Query\Builder
     */
    public function scopeHot($query, $limit = 5, $columns = ['*'])
    {
        return $query->select($columns)->orderBy('view_count', 'desc')->take($limit);
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Query\Builder
     */
    public function scopeLatestPublished($query)
    {
        return $query->orderByDesc('published_at');
    }

    /**
     * @return mixed
     */
    public function getMarkdownContent()
    {
        return $this->getRawContentAttribute();
    }

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
     * @return string
     */
    public function getFeatureImgUrlAttribute()
    {
        $value = $this->getAttribute('feature_img');

        return starts_with($value, ['https://', 'http://']) ? $value : Storage::url($value);
    }
}
