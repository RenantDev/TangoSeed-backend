<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\GroupRRoleCreateRequest;
use App\Http\Requests\GroupRRoleUpdateRequest;
use App\Repositories\GroupRRoleRepository;
use App\Validators\GroupRRoleValidator;


class GroupRRolesController extends Controller
{

    /**
     * @var GroupRRoleRepository
     */
    protected $repository;

    /**
     * @var GroupRRoleValidator
     */
    protected $validator;

    public function __construct(GroupRRoleRepository $repository, GroupRRoleValidator $validator)
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
        $groupRRoles = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $groupRRoles,
            ]);
        }

        return view('groupRRoles.index', compact('groupRRoles'));
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
                'message' => 'GroupRRole created.',
                'data'    => $groupRRole->toArray(),
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
        $groupRRole = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $groupRRole,
            ]);
        }

        return view('groupRRoles.show', compact('groupRRole'));
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

        $groupRRole = $this->repository->find($id);

        return view('groupRRoles.edit', compact('groupRRole'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  GroupRRoleUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     */
    public function update(GroupRRoleUpdateRequest $request, $id)
    {

        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $groupRRole = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'GroupRRole updated.',
                'data'    => $groupRRole->toArray(),
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
                'message' => 'GroupRRole deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'GroupRRole deleted.');
    }
}
