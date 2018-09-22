<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\RoleCategoryRepository;
use App\Entities\RoleCategory;
use App\Validators\RoleCategoryValidator;

/**
 * Class RoleCategoryRepositoryEloquent
 * @package namespace App\Repositories;
 */
class RoleCategoryRepositoryEloquent extends BaseRepository implements RoleCategoryRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return RoleCategory::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return RoleCategoryValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
