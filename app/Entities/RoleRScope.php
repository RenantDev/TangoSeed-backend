<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class RoleRScope extends Model implements Transformable
{
    use TransformableTrait;

    protected $fillable = [
        'role_id',
        'scope_id'
    ];

}
