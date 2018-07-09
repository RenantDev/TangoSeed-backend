<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\LoginRepository;
use App\Entities\Login;
use App\Validators\LoginValidator;

/**
 * Class LoginRepositoryEloquent
 * @package namespace App\Repositories;
 */
class LoginRepositoryEloquent extends BaseRepository implements LoginRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Login::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return LoginValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
