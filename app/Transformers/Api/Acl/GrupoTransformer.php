<?php

namespace App\Transformers\Api\Acl;

use League\Fractal\TransformerAbstract;
use App\Entities\Api\Acl\Grupo;

/**
 * Class GrupoTransformer
 * @package namespace App\Transformers\Api\Acl;
 */
class GrupoTransformer extends TransformerAbstract
{

    /**
     * Transform the Grupo entity
     * @param Grupo $model
     *
     * @return array
     */
    public function transform(Grupo $model)
    {
        return [
            'id'         => (int) $model->id,

            'titulo' => $model->titulo,
            'descricao' => $model->descricao,


            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}