<?php

namespace App\Presenters;

use App\Transformers\RoleRScopeTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class RoleRScopePresenter
 *
 * @package namespace App\Presenters;
 */
class RoleRScopePresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new RoleRScopeTransformer();
    }
}
