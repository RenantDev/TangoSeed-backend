<?php

namespace App\Repositories\Api\Acl;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Api\Acl\FuncaoRepository;
use App\Entities\Api\Acl\Funcao;
use App\Validators\Api\Acl\FuncaoValidator;

/**
 * Class FuncaoRepositoryEloquent
 * @package namespace App\Repositories\Api\Acl;
 */
class FuncaoRepositoryEloquent extends BaseRepository implements FuncaoRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Funcao::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return FuncaoValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
