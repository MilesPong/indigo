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
            "![$faker->word]($faker->imageUrl) {.img-responsive} \n\r " .
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
