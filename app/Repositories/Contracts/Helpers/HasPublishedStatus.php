<?php

namespace App\Repositories\Contracts\Helpers;

interface HasPublishedStatus
{
    /**
     * @return mixed
     */
    public function ignorePublishedStatusMode();

    /**
     * @return bool
     */
    public function wantIgnorePublishedStatus();
}