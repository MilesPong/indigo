<?php

namespace App\Http\Controllers\Auth\Traits;

trait AuthRedirect
{
    /**
     * Where to redirect users after login (Priority)
     *
     * @return string
     */
    protected function redirectTo()
    {
        return route('dashboard.index');
    }
}