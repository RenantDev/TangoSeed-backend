<?php

namespace App\Transformers\Api\Acl;

use League\Fractal\TransformerAbstract;
use App\Entities\Api\Acl\Funcao;

/**
 * Class FuncaoTransformer
 * @package namespace App\Transformers\Api\Acl;
 */
class FuncaoTransformer extends TransformerAbstract
{

    /**
     * Transform the Funcao entity
     * @param App\Entities\Api\Acl\Funcao $model
     *
     * @return array
     */
    public function transform(Funcao $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
