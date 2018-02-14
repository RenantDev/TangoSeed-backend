<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\Profile;

/**
 * Class ProfileTransformer
 * @package namespace App\Transformers;
 */
class ProfileTransformer extends TransformerAbstract
{

    /**
     * Transform the Profile entity
     * @param \App\Entities\Profile $model
     *
     * @return array
     */
    public function transform(Profile $model)
    {
        return [
            'id'         => (int) $model->id,

            'user_id' => (int) $model->user_id,
            'avatar' => (string) $model->avatar,
            'first_name' => (string) $model->first_name,
            'last_name' => (string) $model->last_name,
            'ddd' => (string) $model->ddd,
            'cell_phone' => (string) $model->cell_phone,
            'gender' => (int) $model->gender,
            'status' => (int) $model->gender,

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
