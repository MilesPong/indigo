<?php

namespace App\Observers;

use App\Models\Setting;

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

    }
}