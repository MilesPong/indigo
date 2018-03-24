<?php

namespace App\Http\ViewComposers;

use App\Indigo\Tools\Localization;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Class FooterComposer
 * @package App\Http\ViewComposers
 */
class FooterComposer
{
    /**
     * @var \Illuminate\Http\Request
     */
    protected $request;

    /**
     * FooterComposer constructor.
     * @param \Illuminate\Http\Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @param View $view
     */
    public function compose(View $view)
    {
        $view->with('localeLinks', $this->getLocaleLinks());

        $view->with('currentLocaleName', $this->getCurrentLocaleName());
    }

    /**
     * @return array
     */
    protected function getLocaleLinks(): array
    {
        $fullUrlWithLocale = $this->request->fullUrlWithQuery(['locale' => 'placeholder']);

        $localeLinks = [];

        $supportedLocales = Localization::supportedLocales();

        foreach ($supportedLocales as $locale => $name) {
            $localeLinks[$name] = str_replace('locale=placeholder', "locale={$locale}", $fullUrlWithLocale);
        }

        return $localeLinks;
    }

    /**
     * @return mixed
     */
    protected function getCurrentLocaleName()
    {
        $supportedLocales = Localization::supportedLocales();

        $locale = app()->getLocale();

        return $supportedLocales[$locale] ?? $supportedLocales[0];
    }
}