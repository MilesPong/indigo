<?php

namespace Indigo\Contracts;

/**
 * Interface Markdownable
 * @package Indigo\Contracts
 */
interface Markdownable
{
    /**
     * @return string
     */
    public function getMarkdownContent();
}