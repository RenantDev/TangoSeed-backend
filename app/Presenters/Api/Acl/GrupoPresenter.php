<?php

namespace App\Presenters\Api\Acl;

use App\Transformers\Api\Acl\GrupoTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class GrupoPresenter
 *
 * @package namespace App\Presenters\Api\Acl;
 */
class GrupoPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new GrupoTransformer();
    }
}
