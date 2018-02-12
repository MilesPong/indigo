<?php

namespace App\Models;

use App\Indigo\Contracts\Viewable as ViewableContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Indigo\Contracts\Markdownable;

/**
 * Class Page
 * @package App\Models
 */
class Page extends Model implements Markdownable, ViewableContract
{
    use SoftDeletes, Viewable;

    /**
     * @var array
     */
    protected $fillable = [
        'title',
        'description',
        'slug',
        'is_draft',
        'title',
        'title',
    ];
    /**
     * @var array
     */
    protected $dates = ['deleted_at'];
    /**
     * @var array
     */
    protected $casts = [
        'is_draft' => 'boolean'
    ];

    /**
     * @return string
     */
    public function getMarkdownContent()
    {
        // TODO: Implement getMarkdownContent() method.
    }
}
