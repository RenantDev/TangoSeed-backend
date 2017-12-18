<?php

namespace App\Presenters\Api\Acl;

use App\Transformers\Api\Acl\GrupoFuncaoTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class GrupoFuncaoPresenter
 *
 * @package namespace App\Presenters\Api\Acl;
 */
class GrupoFuncaoPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new GrupoFuncaoTransformer();
    }
}
