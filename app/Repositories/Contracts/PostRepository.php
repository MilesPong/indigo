<?php

namespace App\Repositories\Contracts;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use App\Repositories\Contracts\Repository as RepositoryInterface;

/**
 * Interface PostRepository
 * @package App\Repositories\Contracts
 */
interface PostRepository extends RepositoryInterface, SlugableInterface
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
}
