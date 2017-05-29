<?php

namespace App\Models;

use Zizaco\Entrust\EntrustPermission;

/**
 * Class Permission
 * @package App\Models
 */
class Permission extends EntrustPermission
{
    /**
     * @var array
     */
    protected $fillable = ['name', 'display_name', 'description'];
}
