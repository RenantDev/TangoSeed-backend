<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\ScopeCreateRequest;
use App\Http\Requests\ScopeUpdateRequest;
use App\Repositories\ScopeRepository;
use App\Validators\ScopeValidator;

use App\Http\Controllers\UtilController;


class ScopesController extends Controller
{

    /**
     * @var ScopeRepository
     */
    protected $repository;

    protected $util;

    /**
     * @var ScopeValidator
     */
    protected $validator;

    public function __construct(ScopeRepository $repository, ScopeValidator $validator, UtilController $util)
    {
        $this->repository = $repository;
        $this->validator  = $validator;
        $this->util = $util;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
        $scopes = $this->repository->all();

        if (request()->wantsJson()) {
            return response()->json([
                'data' => $scopes,
            ]);
        }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  ScopeCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(ScopeCreateRequest $request)
    {

        try {

            if(!isset($request->tag)){
                $request->merge(['tag' => $this->util->slug($request->title)]);
            }

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $scope = $this->repository->create($request->all());

            $response = [
                'message' => __('admin.scopes.create.success'),
                'data'    => $scope->toArray(),
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
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try{
            $scope = $this->repository->find($id);
            if (request()->wantsJson()) {
                return response()->json([
                    'data' => $scope,
                ]);
            }
        }catch (\Exception $e){
            if (request()->wantsJson()) {
                return response()->json([
                    'error' => true,
                    'message' => __('admin.scopes.info.error')
                ]);
            }
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ScopeUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     */
    public function update(ScopeUpdateRequest $request, $id)
    {
        try {
            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $scope = $this->repository->update($request->all(), $id);

            $response = [
                'message' => __('admin.scopes.update.success'),
                'data'    => $scope->toArray(),
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
                    'message' => __('admin.scopes.delete.success'),
                    'deleted' => $deleted,
                ]);
            }
        }catch (\Exception $e){
            if (request()->wantsJson()) {
                return response()->json([
                    'error' => true,
                    'message' => __('admin.scopes.delete.error')
                ]);
            }
        }
    }
}
