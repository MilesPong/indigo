<?php

namespace Indigo\Models;

use App\Scopes\PublishedScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Indigo\Contracts\Markdownable;
use Indigo\Contracts\Viewable;
use Indigo\Tools\MarkDownParser;

/**
 * Class Article
 * @package Indigo\Models
 */
abstract class Article extends Model implements Markdownable, Viewable
{
    use SoftDeletes;
    /**
     * Is draft status
     */
    const IS_DRAFT = 1;
    /**
     * Is not draft status
     */
    const IS_NOT_DRAFT = 0;

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
    abstract public function getRawContentAttribute();

    /**
     * @return string
     */
    public function getCountField()
    {
        return 'view_count';
    }

    /**
     * @return mixed
     */
    public function getIdentifier()
    {
        return $this->getKey();
    }

    /**
     * @param $value
     */
    public function setIsDraftAttribute($value)
    {
        $this->attributes['is_draft'] = !empty($value) ? self::IS_DRAFT : self::IS_NOT_DRAFT;
    }

    /**
     * @param $value
     * @return bool
     */
    public function getIsDraftAttribute($value)
    {
        return (boolean)$value;
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
    public function getHtmlContentAttribute()
    {
        // TODO cache
        return MarkDownParser::md2html($this);
    }
}