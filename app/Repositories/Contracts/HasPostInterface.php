<?php

namespace App\Repositories\Contracts;

interface HasPostInterface
{
    /**
     * @param array $columns
     * @return mixed
     */
    public function getResultsHavePosts($columns = ['*']);
}