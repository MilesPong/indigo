<?php

namespace App\Observers;

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

/**
 * Class TagObserver
 * @package App\Observers
 */
class SettingObserver extends BaseObserver
{
    /**
     * @param Setting $setting
     */
    public function saved(Setting $setting)
    {
        Cache::forget($this->cacheHelper->keySiteSettings());
    }
}