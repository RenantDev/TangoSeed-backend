<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\group_r_roleRepository;
use App\Entities\GroupRRole;
use App\Validators\GroupRRoleValidator;

/**
 * Class GroupRRoleRepositoryEloquent
 * @package namespace App\Repositories;
 */
class GroupRRoleRepositoryEloquent extends BaseRepository implements GroupRRoleRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return GroupRRole::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return GroupRRoleValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
