<?php

namespace App\Http\Controllers\Api\Acl;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\GrupoCreateRequest;
use App\Http\Requests\GrupoUpdateRequest;
use App\Repositories\Api\Acl\GrupoRepository;
use App\Validators\Api\Acl\GrupoValidator;


class GruposController extends Controller
{

    /**
     * @var GrupoRepository
     */
    protected $repository;

    /**
     * @var GrupoValidator
     */
    protected $validator;

    public function __construct(GrupoRepository $repository, GrupoValidator $validator)
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
        $grupos = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $grupos,
            ]);
        }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  GrupoCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(GrupoCreateRequest $request)
    {

        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $grupo = $this->repository->create($request->all());

            $response = [
                'message' => 'Grupo created.',
                'data'    => $grupo->toArray(),
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
        $grupo = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $grupo,
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

        $grupo = $this->repository->find($id);

        return view('grupos.edit', compact('grupo'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  GrupoUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     */
    public function update(GrupoUpdateRequest $request, $id)
    {

        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $grupo = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'Grupo updated.',
                'data'    => $grupo->toArray(),
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
                'message' => 'Grupo deleted.',
                'deleted' => $deleted,
            ]);
        }

    }
}
