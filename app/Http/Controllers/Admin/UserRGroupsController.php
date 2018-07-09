<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\UserRGroupCreateRequest;
use App\Repositories\UserRGroupRepository;
use App\Validators\UserRGroupValidator;
use App\Repositories\GroupRepository;
use App\Validators\GroupValidator;

use App\Entities\Group;


class UserRGroupsController extends Controller
{

    /**
     * @var UserRGroupRepository
     */
    protected $repository;
    protected $repositoryGroup;

    /**
     * @var UserRGroupValidator
     */
    protected $validator;
    protected $validatorGroup;

    public function __construct(
        UserRGroupRepository $repository,
        UserRGroupValidator $validator,
        GroupRepository $repositoryGroup,
        GroupValidator $validatorGroup

    )
    {
        $this->repository = $repository;
        $this->validator  = $validator;
        $this->repositoryGroup = $repositoryGroup;
        $this->validatorGroup  = $validatorGroup;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            $this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
            $this->repositoryGroup->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
            $userRGroups = $this->repository->all(['id', 'user_id', 'group_id', 'created_at', 'updated_at']);
            $groups = $this->repositoryGroup->all(['id', 'title', 'description']);

            foreach ($userRGroups AS $key => $value){
                foreach ($groups AS $keyGroup => $valueGroup){
                    if($groups[$keyGroup]['id'] == $userRGroups[$key]['group_id']){
                        $aux1 = json_decode(json_encode($userRGroups[$key]), true);
                        $aux2 = json_decode(json_encode($groups[$keyGroup]), true);
                        $groupsList[$key] = array_merge($aux2, $aux1);
                        continue;
                    }
                }
            }

            if (request()->wantsJson()) {
                return response()->json([
                    'data' => $groupsList,
                ]);
            }
        }catch (\Exception $e){
            if (request()->wantsJson()) {
                return response()->json([
                    'error' => true,
                    'message' => 'O usuário não faz parte de um grupo.',
                ]);
            }
        }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  UserRGroupCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(UserRGroupCreateRequest $request)
    {

        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $userRGroup = $this->repository->create($request->all());

            $response = [
                'message' => __('admin.users-r-group.create.success'),
                'data'    => $userRGroup->toArray(),
            ];

            if ($request->wantsJson()) {
                return response()->json($response);
            }

        } catch (\Exception $e) {
            if ($request->wantsJson()) {
                return response()->json([
                    'error'   => true,
                    'message' => __('admin.users-r-group.create.error')
                ]);
            }

        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            $deleted = $this->repository->delete($id);
            if (request()->wantsJson()) {
                return response()->json([
                    'message' => __('admin.users-r-group.delete.success'),
                    'deleted' => $deleted,
                ]);
            }
        }catch (\Exception $e){
            if (request()->wantsJson()) {
                return response()->json([
                    'error' => true,
                    'message' => __('admin.users-r-group.delete.error')
                ]);
            }
        }

    }
}
