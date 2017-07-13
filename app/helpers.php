<?php

if (!function_exists('markdownContent')) {
    /**
     * Generate post's content in markdown format
     * including headings, quotes, and images.
     *
     * @param \Faker\Generator $faker
     *
     * @return string
     */
    function markdownContent(Faker\Generator $faker)
    {
        $content =
            "$faker->realText \n\r " .
            "## $faker->sentence \n\r " .
            "![$faker->word]($faker->imageUrl) \n\r " .
            "> $faker->sentence \n\r " .
            "### $faker->sentence \n\r " .
            "$faker->paragraph \n\r " .
            "[$faker->sentence](#)";
        return $content;
    }
}

if (!function_exists('setActiveClass')) {
    /**
     * @param $route
     * @param string $class
     * @param string $adminPrefix
     * @return string
     */
    function setActiveClass($route, $class = 'active', $adminPrefix = 'dashboard')
    {
        return Request::is($adminPrefix . '/' . $route . '*') ? $class : '';
    }
}

if (!function_exists('hasChinese')) {
    /**
     * @param $text
     * @return bool
     */
    function hasChinese($text)
    {
        if (preg_match("/\p{Han}+/u", $text)) {
            return true;
        }

        return false;
    }
}

if (!function_exists('str_slug_with_cn')) {

    /**
     * @param $text
     * @param bool $forceTrans
     * @return \Illuminate\Foundation\Application|\JellyBool\Translug\Translation|mixed|string|translug
     */
    function str_slug_with_cn($text, $forceTrans = false)
    {
        if (empty(trim($text))) {
            return '';
        }

        if ($forceTrans || hasChinese($text)) {
            return translug($text);
        }

        return str_slug($text);
    }
}

if (!function_exists('isAdmin')) {
    /**
     * Determine if current user is login and is admin.
     *
     * @return bool
     */
    function isAdmin()
    {
        return auth()->check() && auth()->user()->isAdmin();
    }
}

if (!function_exists('setting')) {
    /**
     * @param $key
     * @return mixed
     */
    function setting($key) {
        return array_get(app('settings'), $key);
    }
}
