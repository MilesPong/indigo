<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['ip', 'uri', 'is_robot', 'platform', 'device', 'browser', 'user_agent'];
}
