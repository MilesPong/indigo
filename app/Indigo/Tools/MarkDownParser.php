<?php

namespace Indigo\Tools;

use Indigo\Contracts\Markdownable;
use League\HTMLToMarkdown\HtmlConverter;
use Parsedown;

/**
 * Class MarkDownParser
 * @package Indigo\Tools
 */
class MarkDownParser
{
    /**
     * @var HtmlConverter
     */
    protected static $htmlConverter;

    // /**
    //  * @var static
    //  */
    // protected static $instance;
    //
    // /**
    //  * @return static
    //  */
    // public static function getInstance()
    // {
    //     if (is_null(static::$instance)) {
    //         static::$instance = new static;
    //     }
    //
    //     return static::$instance;
    // }

    /**
     * Convert markdown into html
     *
     * @param Markdownable $markdownable
     * @return string
     */
    public static function md2html(Markdownable $markdownable)
    {
        $parsedown = Parsedown::instance();

        return $parsedown->setBreaksEnabled(true)->text($markdownable->getMarkdownContent());
    }

    /**
     * Convert html into markdown
     *
     * @param $html
     * @return string
     */
    public static function html2md($html)
    {
        $htmlConverter = self::getHtmlConverter();

        return $htmlConverter->convert($html);
    }

    /**
     * Get the singleton HtmlConverter
     *
     * @return HtmlConverter
     */
    protected static function getHtmlConverter()
    {
        if (!static::$htmlConverter) {
            static::$htmlConverter = new HtmlConverter;
        }

        return static::$htmlConverter;
    }
}
