<?php

namespace App\Presenters\Api\Acl;

use App\Transformers\Api\Acl\FuncaoTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class FuncaoPresenter
 *
 * @package namespace App\Presenters\Api\Acl;
 */
class FuncaoPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new FuncaoTransformer();
    }
}
