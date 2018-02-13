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
     * @see \App\Indigo\Contracts\Viewable::getCountField()
     */
    public function getCountField()
    {
        return 'view_count';
    }

    /**
     * @return mixed
     * @see \App\Indigo\Contracts\Viewable::getIdentifier()
     */
    public function getIdentifier()
    {
        return $this->getKey();
    }
}