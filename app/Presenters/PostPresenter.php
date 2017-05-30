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
}