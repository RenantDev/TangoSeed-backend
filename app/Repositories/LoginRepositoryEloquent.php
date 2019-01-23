<?php

namespace App\Repositories;

use App\Entities\Login;
use App\Repositories\LoginRepository;
use App\Validators\LoginValidator;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class LoginRepositoryEloquent
 * @package namespace App\Repositories;
 */
class LoginRepositoryEloquent extends BaseRepository implements LoginRepository
{

    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'email',
    ];

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
