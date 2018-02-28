<?php

namespace App\Models;

use App\Presenters\PostPresenter;
use Illuminate\Support\Facades\Storage;
use Indigo\Contracts\HasPublishedTime;
use Indigo\Models\Article as ArticleModel;
use Laracasts\Presenter\PresentableTrait;
use Laravel\Scout\Searchable;

/**
 * Class Post
 * @package App\Models
 */
class Post extends ArticleModel implements HasPublishedTime
{
    use PresentableTrait, Searchable;
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

    /**
     * @return string
     */
    public function getPermalink()
    {
        return route('articles.show', $this->getAttribute('slug'));
    }

    /**
     * Get the indexable data array for the model.
     *
     * @return array
     */
    public function toSearchableArray()
    {
        return array_merge($this->toArray(), [
            // Equal to $this->html_content
            'content' => strip_tags($this->getAttribute('html_content'))
        ]);
    }
}
