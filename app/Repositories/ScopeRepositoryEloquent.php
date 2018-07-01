<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\ScopeRepository;
use App\Entities\Scope;
use App\Validators\ScopeValidator;

/**
 * Class ScopeRepositoryEloquent
 * @package namespace App\Repositories;
 */
class ScopeRepositoryEloquent extends BaseRepository implements ScopeRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Scope::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return ScopeValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
