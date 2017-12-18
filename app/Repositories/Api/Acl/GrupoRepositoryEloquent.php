<?php

namespace App\Repositories\Api\Acl;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Api\Acl\GrupoRepository;
use App\Entities\Api\Acl\Grupo;
use App\Validators\Api\Acl\GrupoValidator;

/**
 * Class GrupoRepositoryEloquent
 * @package namespace App\Repositories\Api\Acl;
 */
class GrupoRepositoryEloquent extends BaseRepository implements GrupoRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Grupo::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return GrupoValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
