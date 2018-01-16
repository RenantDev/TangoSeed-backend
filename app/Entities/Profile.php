<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Profile extends Model implements Transformable
{
    use TransformableTrait;

    protected $fillable = [
        'avatar',
        'first_name',
        'last_name',
        'ddd',
        'cell_phone',
        'gender',
        'status'
    ];

}
