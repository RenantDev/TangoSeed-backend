<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\role_r_scopeRepository;
use App\Entities\RoleRScope;
use App\Validators\RoleRScopeValidator;

/**
 * Class RoleRScopeRepositoryEloquent
 * @package namespace App\Repositories;
 */
class RoleRScopeRepositoryEloquent extends BaseRepository implements RoleRScopeRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return RoleRScope::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return RoleRScopeValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
