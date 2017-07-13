<?php

namespace App\Repositories\Eloquent;

use App\Models\Setting;
use App\Repositories\Contracts\SettingRepository;

/**
 * Class SettingRepositoryEloquent
 * @package App\Repositories\Eloquent
 */
class SettingRepositoryEloquent extends BaseRepository implements SettingRepository
{
    /**
     * @return string
     */
    public function model()
    {
        return Setting::class;
    }
}
