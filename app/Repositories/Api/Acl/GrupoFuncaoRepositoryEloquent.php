<?php

namespace App\Repositories\Api\Acl;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Api\Acl\GrupoFuncaoRepository;
use App\Entities\Api\Acl\GrupoFuncao;
use App\Validators\Api\Acl\GrupoFuncaoValidator;

/**
 * Class GrupoFuncaoRepositoryEloquent
 * @package namespace App\Repositories\Api\Acl;
 */
class GrupoFuncaoRepositoryEloquent extends BaseRepository implements GrupoFuncaoRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return GrupoFuncao::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return GrupoFuncaoValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
