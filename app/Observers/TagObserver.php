<?php

namespace App\Observers;

use App\Models\Tag;

/**
 * Class TagObserver
 * @package App\Observers
 */
class TagObserver extends BaseObserver
{
    /**
     * @param Tag $tag
     */
    public function updated(Tag $tag)
    {

    }
}