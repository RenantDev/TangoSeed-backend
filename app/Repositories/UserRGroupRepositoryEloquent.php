<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\user_r_groupRepository;
use App\Entities\UserRGroup;
use App\Validators\UserRGroupValidator;

/**
 * Class UserRGroupRepositoryEloquent
 * @package namespace App\Repositories;
 */
class UserRGroupRepositoryEloquent extends BaseRepository implements UserRGroupRepository
{

    protected $fieldSearchable = [
        'user_id',
        'group_id'
    ];

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return UserRGroup::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return UserRGroupValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
