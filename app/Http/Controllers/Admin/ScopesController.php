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


class ScopesController extends Controller
{

    /**
     * @var ScopeRepository
     */
    protected $repository;

    /**
     * @var ScopeValidator
     */
    protected $validator;

    public function __construct(ScopeRepository $repository, ScopeValidator $validator)
    {
        $this->repository = $repository;
        $this->validator  = $validator;
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

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $scope = $this->repository->create($request->all());

            $response = [
                'message' => 'Scope created.',
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
        $scope = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $scope,
            ]);
        }

    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $scope = $this->repository->find($id);

        return view('scopes.edit', compact('scope'));
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
                'message' => 'Scope updated.',
                'data'    => $scope->toArray(),
            ];

            if ($request->wantsJson()) {

                return response()->json($response);
            }

            return redirect()->back()->with('message', $response['message']);
        } catch (ValidatorException $e) {

            if ($request->wantsJson()) {

                return response()->json([
                    'error'   => true,
                    'message' => $e->getMessageBag()
                ]);
            }

            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
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
        $deleted = $this->repository->delete($id);

        if (request()->wantsJson()) {

            return response()->json([
                'message' => 'Scope deleted.',
                'deleted' => $deleted,
            ]);
        }
    }
}
