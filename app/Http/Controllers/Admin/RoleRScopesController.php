<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\ScopeRepository;
use App\Validators\ScopeValidator;

use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;

use App\Http\Requests\RoleRScopeCreateRequest;
use App\Repositories\RoleRScopeRepository;
use App\Validators\RoleRScopeValidator;


class RoleRScopesController extends Controller
{

    /**
     * @var RoleRScopeRepository
     */
    protected $repository;
    protected $repositoryScopes;

    /**
     * @var RoleRScopeValidator
     */
    protected $validator;
    protected $validatorScopes;

    public function __construct(
        RoleRScopeRepository $repository,
        RoleRScopeValidator $validator,
        ScopeRepository $repositoryScopes,
        ScopeValidator $validatorScopes
    )
    {
        $this->repository = $repository;
        $this->validator  = $validator;
        $this->repositoryScopes = $repositoryScopes;
        $this->validatorScopes  = $validatorScopes;
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
            $this->repositoryScopes->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
            $roleRScopes = $this->repository->all(['id', 'role_id', 'scope_id', 'created_at', 'updated_at']);
            $scopes = $this->repositoryScopes->all(['id', 'tag', 'title', 'description']);

            foreach ($roleRScopes AS $key => $value){
                foreach ($scopes AS $keyScope => $valueScope){
                    if($scopes[$keyScope]['id'] == $roleRScopes[$key]['scope_id']){
                        $aux1 = json_decode(json_encode($roleRScopes[$key]), true);
                        $aux2 = json_decode(json_encode($scopes[$keyScope]), true);
                        $scopeList[$key] = array_merge($aux2, $aux1);
                        continue;
                    }
                }
            }

            if (request()->wantsJson()) {
                return response()->json([
                    'data' => $scopeList,
                ]);
            }
        }catch (\Exception $e){
            if (request()->wantsJson()) {
                return response()->json([
                    'error' => true,
                    'message' => __('admin.role-r-scopes.info.error'),
                ]);
            }
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  RoleRScopeCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(RoleRScopeCreateRequest $request)
    {

        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $roleRScope = $this->repository->create($request->all());

            $response = [
                'message' => __('admin.role-r-scopes.create.success'),
                'data'    => $roleRScope->toArray(),
            ];

            if ($request->wantsJson()) {

                return response()->json($response);
            }

        } catch (ValidatorException $e) {
            if ($request->wantsJson()) {
                return response()->json([
                    'error'   => true,
                    'message' => $e->getMessageBag()
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
                    'message' => __('admin.role-r-scopes.delete.success'),
                    'deleted' => $deleted,
                ]);
            }
        }catch (\Exception $e){
            if (request()->wantsJson()) {
                return response()->json([
                    'message' => __('admin.role-r-scopes.delete.error'),
                    'deleted' => $deleted,
                ]);
            }
        }

    }
}
