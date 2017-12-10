<?php

namespace App\Contracts;

/**
 * Interface ContentableInterface
 * @package App\Contracts
 */
interface ContentableInterface
{
    /**
     * Get raw content in markdown syntax.
     *
     * @return string
     */
    public function getRawContent();

    /**
     * Get primary key in 'contents' table.
     *
     * @return int
     */
    public function getContentId();
}