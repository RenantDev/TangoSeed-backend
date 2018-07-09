<?php

namespace App\Presenters;

use App\Transformers\GroupRRoleTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class GroupRRolePresenter
 *
 * @package namespace App\Presenters;
 */
class GroupRRolePresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new GroupRRoleTransformer();
    }
}
