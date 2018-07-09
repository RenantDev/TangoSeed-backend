<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\UserRGroupCreateRequest;
use App\Http\Requests\UserRGroupUpdateRequest;
use App\Repositories\UserRGroupRepository;
use App\Validators\UserRGroupValidator;


class UserRGroupsController extends Controller
{

    /**
     * @var UserRGroupRepository
     */
    protected $repository;

    /**
     * @var UserRGroupValidator
     */
    protected $validator;

    public function __construct(UserRGroupRepository $repository, UserRGroupValidator $validator)
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
        $userRGroups = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $userRGroups,
            ]);
        }

        return view('userRGroups.index', compact('userRGroups'));
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
                'message' => 'UserRGroup created.',
                'data'    => $userRGroup->toArray(),
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
        $userRGroup = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $userRGroup,
            ]);
        }

        return view('userRGroups.show', compact('userRGroup'));
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

        $userRGroup = $this->repository->find($id);

        return view('userRGroups.edit', compact('userRGroup'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  UserRGroupUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     */
    public function update(UserRGroupUpdateRequest $request, $id)
    {

        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $userRGroup = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'UserRGroup updated.',
                'data'    => $userRGroup->toArray(),
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
                'message' => 'UserRGroup deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'UserRGroup deleted.');
    }
}
