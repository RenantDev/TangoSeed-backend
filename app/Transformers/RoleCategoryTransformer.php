<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\RoleCategory;

/**
 * Class RoleCategoryTransformer
 * @package namespace App\Transformers;
 */
class RoleCategoryTransformer extends TransformerAbstract
{

    /**
     * Transform the RoleCategory entity
     * @param App\Entities\RoleCategory $model
     *
     * @return array
     */
    public function transform(RoleCategory $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
