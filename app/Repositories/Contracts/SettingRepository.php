<?php

namespace App\Repositories\Contracts;

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
