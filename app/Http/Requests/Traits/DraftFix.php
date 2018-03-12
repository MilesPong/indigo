<?php

namespace App\Http\Requests\Traits;

/**
 * Trait DraftFix
 * @package App\Http\Requests\Traits
 */
trait DraftFix
{
    /**
     * @return void
     */
    public function fixDraftInput()
    {
        if (!$this->has('is_draft')) {
            $this->merge(['is_draft' => null]);
        }
    }
}