<?php

namespace App\Entities\Api\Acl;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Funcao extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = "funcoes";

    protected $fillable = [];

}
