<?php

namespace App\Indigo\Contracts;

/**
 * Interface Viewable
 * @package App\Indigo\Contracts
 */
interface Viewable
{
    /**
     * @return string
     */
    public function getCountField();

    /**
     * @return mixed
     */
    public function getIdentifier();
}