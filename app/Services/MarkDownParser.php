<?php

namespace App\Services;

use Parsedown;
use League\HTMLToMarkdown\HtmlConverter;

/**
 * Class MarkDownParser
 * @package App\Services
 */
class MarkDownParser
{
    /**
     * @var Parsedown
     */
    protected $markdownConverter;

    /**
     * @var HtmlConverter
     */
    protected $htmlConverter;

    /**
     * MarkDownParser constructor.
     * @param Parsedown $markdownConverter
     * @param HtmlConverter $htmlConverter
     */
    public function __construct(Parsedown $markdownConverter, HtmlConverter $htmlConverter)
    {
        $this->markdownConverter = $markdownConverter;
        $this->htmlConverter = $htmlConverter;
    }

    /**
     * Convert markdown into html
     *
     * @param $markdown
     * @return string
     */
    public function md2html($markdown)
    {
        return $this->markdownConverter->setBreaksEnabled(true)->text($markdown);
    }

    /**
     * Convert html into markdown
     *
     * @param $html
     * @return string
     */
    public function html2md($html)
    {
        return $this->htmlConverter->convert($html);
    }
}
