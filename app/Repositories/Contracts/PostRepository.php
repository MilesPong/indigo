<?php

namespace App\Repositories\Contracts;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use App\Repositories\Contracts\Helpers\HasPublishedStatus;
use App\Repositories\Contracts\Helpers\SlugableInterface;
use App\Repositories\Contracts\Repository as RepositoryInterface;

/**
 * Interface PostRepository
 * @package App\Repositories\Contracts
 */
interface PostRepository extends RepositoryInterface, SlugableInterface, HasPublishedStatus
{
    /**
     * @param \App\Models\Post $model
     * @return mixed
     */
    public function previous(Post $model);

    /**
     * @param \App\Models\Post $model
     * @return mixed
     */
    public function next(Post $model);

    /**
     * @param int $limit
     * @return mixed
     */
    public function hot($limit = 5);

    /**
     * @param \App\Models\Category $category
     * @return mixed
     */
    public function paginateOfCategory(Category $category);

    /**
     * @param \App\Models\Tag $tag
     * @return mixed
     */
    public function paginateOfTag(Tag $tag);

    /**
     * @param string $column
     * @return $this
     */
    public function latestPublished($column = 'published_at');

    /**
     * @param null $perPage
     * @param array $columns
     * @return mixed
     */
    public function frontendPaginate($perPage = null, $columns = ['*']);

    /**
     * @param null $perPage
     * @param array $columns
     * @return mixed
     */
    public function backendPaginate($perPage = null, $columns = ['*']);

    /**
     * @param $slug
     * @param bool $copyright
     * @return string
     */
    public function markdown($slug, $copyright = true);

    /**
     * @param string $text
     * @return mixed
     */
    public function search($text);

    /**
     * @return mixed
     */
    public function getFeedItems();

    /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function archives();
}
