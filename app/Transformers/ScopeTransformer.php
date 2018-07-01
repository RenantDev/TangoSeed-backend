<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\Scope;

/**
 * Class ScopeTransformer
 * @package namespace App\Transformers;
 */
class ScopeTransformer extends TransformerAbstract
{

    /**
     * Transform the Scope entity
     * @param App\Entities\Scope $model
     *
     * @return array
     */
    public function transform(Scope $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
