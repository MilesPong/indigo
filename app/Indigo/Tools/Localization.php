<?php

namespace Indigo\Tools;

use Illuminate\Http\Request;

/**
 * Class Localization
 * @package App\Indigo\Tools
 */
class Localization
{
    /**
     * @var array
     */
    protected static $supportedLocales = [];

    /**
     * Retrieve locale from cookie or header.
     *
     * @param \Illuminate\Http\Request $request
     * @param $localeName
     * @return array|null|string
     */
    public static function retrieveLocale(Request $request, $localeName)
    {
        $locale = $request->cookie($localeName);

        // If have cookie
        if ($locale && self::isSupportedLocale($locale)) {
            return $locale;
        }

        $priorityOrderedLocales = self::getPriorityOrderedLocales($request->header('Accept-Language'));

        return empty($priorityOrderedLocales) ? null : self::getBestAvailableLocale($priorityOrderedLocales);
    }

    /**
     * @param $locale
     * @return bool
     */
    protected static function isSupportedLocale($locale)
    {
        $locales = self::supportedLocales();

        return isset($locales[$locale]);
    }

    /**
     * @return array
     */
    public static function supportedLocales()
    {
        if (empty(self::$supportedLocales)) {
            self::$supportedLocales = config('indigo.supported_locales', ['en' => 'English']);
        }

        return self::$supportedLocales;
    }

    /**
     * Sort the request locale by quality values from "Accept-Language" header
     *
     * @param $languages
     * @return array
     */
    protected static function getPriorityOrderedLocales($languages)
    {
        $locales = [];
        foreach (explode(',', $languages) as $language) {
            $localeArr = explode(';', $language);

            $locales[$localeArr[0]] = isset($localeArr[1]) ? (float)str_replace('q=', '', $localeArr[1]) : 1.0;
        }

        arsort($locales);

        return $locales;
    }

    /**
     * Find out best available locale based on HTTP "Accept-Language" header
     *
     * @param $locales
     * @return null|string
     */
    protected static function getBestAvailableLocale($locales)
    {
        $supportedLocales = self::supportedLocales();

        foreach ($locales as $locale => $weight) {
            if (isset($supportedLocales[$locale])) {
                return $locale;
            }
        }

        return null;
    }

    /**
     * @return \Illuminate\Config\Repository|mixed
     */
    public static function getFallbackLocale()
    {
        return config('app.fallback_locale', 'en');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param $localeName
     * @return null|string
     */
    public static function getValidLocaleFromRequest(Request $request, $localeName)
    {
        $requestLocale = $request->query($localeName);

        return ($requestLocale && self::isSupportedLocale($requestLocale)) ? $requestLocale : null;
    }
}