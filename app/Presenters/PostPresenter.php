<?php

namespace App\Presenters;

use Laracasts\Presenter\Presenter;

/**
 * Class PostPresenter
 * @package App\Presenters
 */
class PostPresenter extends Presenter
{
    /**
     * @return string
     */
    public function selectedTags()
    {
        if (old('tag')) {
            $tagArr = array_map(function ($tagName) {
                return '"' . $tagName . '"';
            }, old('tag'));

            return implode(',', $tagArr);
        }

        return $this->tags->pluck('name')->map(function ($tagName) {
            return '"' . $tagName . '"';
        })->implode(',');
    }

    /**
     * @return false|mixed|null|string
     */
    public function publishedTime()
    {
        if ($old = old('published_at')) {
            return $old;
        }

        if ($this->published_at) {
            return date('m/d/Y g:i A', $this->published_at->timestamp);
        }

        return null;
    }
}