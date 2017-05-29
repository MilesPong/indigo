<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Tag
 * @package App\Models
 */
class Tag extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['name', 'description', 'slug'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function posts()
    {
        return $this->morphedByMany(Post::class, 'taggable');
    }
}
