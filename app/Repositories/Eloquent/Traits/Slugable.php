<?php

namespace App\Repositories\Eloquent\Traits;

use App\Repositories\Contracts\Helpers\HasPublishedStatus;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

/**
 * Trait Slugable
 * @package App\Repositories\Eloquent\Traits
 */
trait Slugable
{
    /**
     * @param $slug
     * @param string $field
     * @return \Illuminate\Database\Eloquent\Model|static|string
     * @throws \App\Repositories\Exceptions\RepositoryException
     * @see \App\Repositories\Contracts\Helpers\SlugableInterface::getBySlug()
     */
    public function getBySlug($slug, $field = 'slug')
    {
        $this->ifShouldIgnorePublishedStatus();

        return $this->findBy($field, $slug);
    }

    /**
     * @return void
     */
    protected function ifShouldIgnorePublishedStatus()
    {
        if ($this instanceof HasPublishedStatus && $this->wantIgnorePublishedStatus() && Auth::check()) {
            $this->ignorePublishedStatusMode();
        }
    }

    /**
     * @param $id
     * @return string
     * @see \App\Repositories\Contracts\Helpers\SlugableInterface::getSlug()
     */
    public function getSlug($id)
    {
        $column = 'slug';

        return $this->useResource(false)->find($id, [$column])->getAttribute($column);
    }
}