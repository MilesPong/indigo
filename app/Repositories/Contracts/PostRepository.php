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
interface PostRepository extends RepositoryInterface, SlugInterface
{
    /**
     * @param array $attributes
     * @return mixed
     */
    public function createPost(array $attributes);

    /**
     * @param array $attributes
     * @param $id
     * @return mixed
     */
    public function updatePost(array $attributes, $id);

    // /**
    //  * @param null $perPage
    //  * @return mixed
    //  */
    // public function lists($perPage = null);

    /**
     * @param $id
     * @return mixed
     */
    public function retrieve($id);

    /**
     * @param Post $model
     * @return mixed
     */
    public function previous(Post $model);

    /**
     * @param Post $model
     * @return mixed
     */
    public function next(Post $model);

    /**
     * @param int $limit
     * @return mixed
     */
    public function hot($limit = 5);

    /**
     * @param Category $category
     * @return mixed
     */
    public function paginateOfCategory(Category $category);

    /**
     * @param Tag $tag
     * @return mixed
     */
    public function paginateOfTag(Tag $tag);
}
