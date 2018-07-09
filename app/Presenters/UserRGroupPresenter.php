<?php

namespace App\Presenters;

use App\Transformers\UserRGroupTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class UserRGroupPresenter
 *
 * @package namespace App\Presenters;
 */
class UserRGroupPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new UserRGroupTransformer();
    }
}
