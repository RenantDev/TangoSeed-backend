<?php

namespace App\Presenters;

use App\Transformers\LoginTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class LoginPresenter
 *
 * @package namespace App\Presenters;
 */
class LoginPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new LoginTransformer();
    }
}
