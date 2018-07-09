<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\RoleRScopeCreateRequest;
use App\Http\Requests\RoleRScopeUpdateRequest;
use App\Repositories\RoleRScopeRepository;
use App\Validators\RoleRScopeValidator;


class RoleRScopesController extends Controller
{

    /**
     * @var RoleRScopeRepository
     */
    protected $repository;

    /**
     * @var RoleRScopeValidator
     */
    protected $validator;

    public function __construct(RoleRScopeRepository $repository, RoleRScopeValidator $validator)
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
        $roleRScopes = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $roleRScopes,
            ]);
        }

        return view('roleRScopes.index', compact('roleRScopes'));
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
                'message' => 'RoleRScope created.',
                'data'    => $roleRScope->toArray(),
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
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $roleRScope = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $roleRScope,
            ]);
        }

        return view('roleRScopes.show', compact('roleRScope'));
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

        $roleRScope = $this->repository->find($id);

        return view('roleRScopes.edit', compact('roleRScope'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  RoleRScopeUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     */
    public function update(RoleRScopeUpdateRequest $request, $id)
    {

        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $roleRScope = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'RoleRScope updated.',
                'data'    => $roleRScope->toArray(),
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
                'message' => 'RoleRScope deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'RoleRScope deleted.');
    }
}
