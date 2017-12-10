<?php

namespace App\Repositories\Contracts;

interface PostRelated
{
    /**
     * @param array $columns
     * @return mixed
     */
    public function allWithPostCount($columns = ['*']);

    /**
     * @param $slug
     * @return mixed
     */
    public function getWithPosts($slug);
}