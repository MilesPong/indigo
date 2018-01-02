<?php

namespace App\Repositories\Contracts\Helpers;

/**
 * Interface ApiResourceInterface
 * @package App\Repositories\Contracts\Helpers
 */
interface ApiResourceInterface
{
    /**
     * @param bool $switch
     * @return mixed
     */
    public function useResource($switch = true);
}