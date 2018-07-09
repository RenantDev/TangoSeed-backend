<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\UserRGroup;

/**
 * Class UserRGroupTransformer
 * @package namespace App\Transformers;
 */
class UserRGroupTransformer extends TransformerAbstract
{

    /**
     * Transform the UserRGroup entity
     * @param App\Entities\UserRGroup $model
     *
     * @return array
     */
    public function transform(UserRGroup $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
