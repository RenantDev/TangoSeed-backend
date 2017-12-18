<?php

namespace App\Entities\Api\Acl;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class GrupoFuncao extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = "grupo_funcoes";

    protected $fillable = [];

}
