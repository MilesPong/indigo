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
