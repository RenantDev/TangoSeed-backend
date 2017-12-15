<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\AclRepository;
use App\Entities\Acl;
use App\Validators\AclValidator;

/**
 * Class AclRepositoryEloquent
 * @package namespace App\Repositories;
 */
class AclRepositoryEloquent extends BaseRepository implements AclRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Acl::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
