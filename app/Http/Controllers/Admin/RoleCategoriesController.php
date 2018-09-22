<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\RoleCategoryCreateRequest;
use App\Http\Requests\RoleCategoryUpdateRequest;
use App\Repositories\RoleCategoryRepository;
use App\Validators\RoleCategoryValidator;


class RoleCategoriesController extends Controller
{

    /**
     * @var RoleCategoryRepository
     */
    protected $repository;

    /**
     * @var RoleCategoryValidator
     */
    protected $validator;

    public function __construct(RoleCategoryRepository $repository, RoleCategoryValidator $validator)
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
        $roleCategories = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $roleCategories,
            ]);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  RoleCategoryCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(RoleCategoryCreateRequest $request)
    {

        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $roleCategory = $this->repository->create($request->all());

            $response = [
                'message' => 'RoleCategory created.',
                'data'    => $roleCategory->toArray(),
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
        $roleCategory = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $roleCategory,
            ]);
        }

        return view('roleCategories.show', compact('roleCategory'));
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

        $roleCategory = $this->repository->find($id);

        return view('roleCategories.edit', compact('roleCategory'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  RoleCategoryUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     */
    public function update(RoleCategoryUpdateRequest $request, $id)
    {

        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $roleCategory = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'RoleCategory updated.',
                'data'    => $roleCategory->toArray(),
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
        $deleted = $this->repository->delete($id);

        if (request()->wantsJson()) {

            return response()->json([
                'message' => 'RoleCategory deleted.',
                'deleted' => $deleted,
            ]);
        }
    }
}
