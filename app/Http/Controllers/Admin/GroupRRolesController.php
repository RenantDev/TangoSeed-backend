<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\RoleRepository;
use App\Validators\RoleValidator;

use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;

use App\Http\Requests\GroupRRoleCreateRequest;
use App\Repositories\GroupRRoleRepository;
use App\Validators\GroupRRoleValidator;


class GroupRRolesController extends Controller
{

    /**
     * @var GroupRRoleRepository
     */
    protected $repository;
    protected $repositoryRole;

    /**
     * @var GroupRRoleValidator
     */
    protected $validator;
    protected $roleValidator;

    public function __construct(
        GroupRRoleRepository $repository,
        GroupRRoleValidator $validator,
        RoleRepository $repositoryRole,
        RoleValidator $validatorRole
    )
    {
        $this->repository = $repository;
        $this->validator  = $validator;
        $this->repositoryRole = $repositoryRole;
        $this->validatorRole = $validatorRole;
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
            $this->repositoryRole->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
            $groupRRoles = $this->repository->all(['id', 'group_id', 'role_id', 'created_at', 'updated_at']);
            $roles = $this->repositoryRole->all(['id', 'title', 'description']);

            foreach ($groupRRoles AS $key => $value){
                foreach ($roles AS $keyRole => $valueRole){
                    if($roles[$keyRole]['id'] == $groupRRoles[$key]['role_id']){
                        $aux1 = json_decode(json_encode($groupRRoles[$key]), true);
                        $aux2 = json_decode(json_encode($roles[$keyRole]), true);
                        $roleList[$key] = array_merge($aux2, $aux1);
                        continue;
                    }
                }
            }

            if (request()->wantsJson()) {
                return response()->json([
                    'data' => $roleList,
                ]);
            }
        }catch (\Exception $e){
            if (request()->wantsJson()) {
                return response()->json([
                    'error' => true,
                    'message' => __('admin.group-r-roles.info.error'),
                ]);
            }
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  GroupRRoleCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(GroupRRoleCreateRequest $request)
    {

        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $groupRRole = $this->repository->create($request->all());

            $response = [
                'message' => __('admin.group-r-roles.create.success'),
                'data'    => $groupRRole->toArray(),
            ];

            if ($request->wantsJson()) {
                return response()->json($response);
            }

        } catch (ValidatorException $e) {
            if ($request->wantsJson()) {
                return response()->json([
                    'error'   => true,
                    'message' => __('admin.group-r-roles.create.error')
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
                    'message' => __('admin.group-r-roles.delete.success'),
                    'deleted' => $deleted,
                ]);
            }
        }catch (\Exception $e){
            if (request()->wantsJson()) {
                return response()->json([
                    'error' => true,
                    'message' => __('admin.group-r-roles.delete.error')
                ]);
            }
        }
    }
}
