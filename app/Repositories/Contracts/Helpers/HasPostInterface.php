<?php

namespace App\Repositories\Contracts\Helpers;

interface HasPostInterface
{
    /**
     * @param array $columns
     * @return mixed
     */
    public function getResultsHavePosts($columns = ['*']);
}