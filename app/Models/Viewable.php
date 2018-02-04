<?php

namespace App\Models;

/**
 * Trait Viewable
 * @package App\Models
 */
trait Viewable
{
    /**
     * @return string
     */
    public function getCountField()
    {
        return 'view_count';
    }

    /**
     * @return mixed
     */
    public function getIdentifier()
    {
        return $this->getKey();
    }
}