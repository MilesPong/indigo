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
        $imgUrl = random_img_url();
        $content =
            "$faker->realText \n\r " .
            "## $faker->sentence \n\r " .
            "![$faker->word]($imgUrl) \n\r " .
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
     * @return \JellyBool\Translug\Translation|mixed|string
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
    function setting($key)
    {
        return array_get(app('settings'), $key);
    }
}

if (!function_exists('random_img_url')) {
    /**
     * @param int $width
     * @param int $height
     * @return string
     */
    function random_img_url($width = 640, $height = 480)
    {
        return "https://temp.im/{$width}x{$height}/" . strtoupper(dechex(rand(0x000000, 0xFFFFFF)));
    }
}

if (!function_exists('human_filesize')) {
    /**
     * @param $bytes
     * @param int $decimals
     * @return string
     */
    function human_filesize($bytes, $decimals = 2) {
        $sz = 'BKMGTP';
        $factor = floor((strlen($bytes) - 1) / 3);
        return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$sz[$factor];
    }
}
