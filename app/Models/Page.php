<?php

namespace App\Models;

use App\Indigo\Contracts\Viewable as ViewableContract;
use App\Scopes\PublishedScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Indigo\Contracts\Markdownable;
use Indigo\Tools\MarkDownParser;

/**
 * Class Page
 * @package App\Models
 */
class Page extends Model implements Markdownable, ViewableContract
{
    use SoftDeletes, Viewable;
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
     * @return string
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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * @return array|\Illuminate\Contracts\Translation\Translator|null|string
     */
    public function getHumanStatusAttribute()
    {
        return $this->getAttribute('is_draft') ? trans('not_show') : trans('show');
    }

    /**
     * @return string
     */
    public function getContentAttribute()
    {
        // TODO cache
        return MarkDownParser::md2html($this);
    }
}
