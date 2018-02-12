<?php

namespace App\Repositories\Eloquent;

use App\Models\Page;
use App\Repositories\Contracts\PageRepository;
use App\Repositories\Eloquent\Traits\Slugable;

/**
 * Class PageRepositoryEloquent
 * @package App\Repositories\Eloquent
 */
class PageRepositoryEloquent extends BaseRepository implements PageRepository
{
    use Slugable;

    /**
     * @return string
     */
    public function model()
    {
        return Page::class;
    }
}