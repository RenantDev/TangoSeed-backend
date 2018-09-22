<?php

namespace App\Presenters;

use App\Transformers\RoleCategoryTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class RoleCategoryPresenter
 *
 * @package namespace App\Presenters;
 */
class RoleCategoryPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new RoleCategoryTransformer();
    }
}
