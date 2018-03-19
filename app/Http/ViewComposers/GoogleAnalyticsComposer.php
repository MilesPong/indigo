<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;

/**
 * Class GoogleAnalyticsComposer
 * @package App\Http\ViewComposers
 */
class GoogleAnalyticsComposer
{
    /**
     * @param \Illuminate\View\View $view
     */
    public function compose(View $view)
    {
        $view->with('traceId', config('indigo.analytics.google_trace_id'));
    }
}