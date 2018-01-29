<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Repositories\Contracts\Helpers\ApiResourceInterface;

/**
 * Class FrontendController
 * @package App\Http\Controllers\Frontend
 */
class FrontendController extends Controller
{
    /**
     * @param string|array $repositories
     * @return void
     */
    protected function disableApiResource($repositories)
    {
        $repositories = is_string($repositories) ? func_get_args() : $repositories;

        foreach ($repositories as $repository) {
            if ($repository instanceof ApiResourceInterface) {
                $repository->useResource(false);
            }
        }
    }
}