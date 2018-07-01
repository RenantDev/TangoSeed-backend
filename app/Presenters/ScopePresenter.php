<?php

namespace App\Presenters;

use App\Transformers\ScopeTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class ScopePresenter
 *
 * @package namespace App\Presenters;
 */
class ScopePresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new ScopeTransformer();
    }
}
