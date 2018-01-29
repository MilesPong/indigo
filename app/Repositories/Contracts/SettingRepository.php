<?php

namespace App\Repositories\Contracts;

use App\Repositories\Contracts\Repository as RepositoryInterface;

/**
 * Interface SettingRepository
 * @package App\Repositories\Contracts
 */
interface SettingRepository extends RepositoryInterface
{
    /**
     * @param null $tag
     * @return mixed
     */
    public function siteSettings($tag = null);
}
