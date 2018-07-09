<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\GroupRRole;

/**
 * Class GroupRRoleTransformer
 * @package namespace App\Transformers;
 */
class GroupRRoleTransformer extends TransformerAbstract
{

    /**
     * Transform the GroupRRole entity
     * @param App\Entities\GroupRRole $model
     *
     * @return array
     */
    public function transform(GroupRRole $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
