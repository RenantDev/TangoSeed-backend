<?php

namespace App\Http\Controllers\Api\Acl;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\GrupoFuncaoCreateRequest;
use App\Http\Requests\GrupoFuncaoUpdateRequest;
use App\Repositories\Api\Acl\GrupoFuncaoRepository;
use App\Validators\Api\Acl\GrupoFuncaoValidator;


class GrupoFuncaosController extends Controller
{

    /**
     * @var GrupoFuncaoRepository
     */
    protected $repository;

    /**
     * @var GrupoFuncaoValidator
     */
    protected $validator;

    public function __construct(GrupoFuncaoRepository $repository, GrupoFuncaoValidator $validator)
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
        $grupoFuncaos = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $grupoFuncaos,
            ]);
        }

        return view('grupoFuncaos.index', compact('grupoFuncaos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  GrupoFuncaoCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(GrupoFuncaoCreateRequest $request)
    {

        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $grupoFuncao = $this->repository->create($request->all());

            $response = [
                'message' => 'GrupoFuncao created.',
                'data'    => $grupoFuncao->toArray(),
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
        $grupoFuncao = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $grupoFuncao,
            ]);
        }

        return view('grupoFuncaos.show', compact('grupoFuncao'));
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

        $grupoFuncao = $this->repository->find($id);

        return view('grupoFuncaos.edit', compact('grupoFuncao'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  GrupoFuncaoUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     */
    public function update(GrupoFuncaoUpdateRequest $request, $id)
    {

        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $grupoFuncao = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'GrupoFuncao updated.',
                'data'    => $grupoFuncao->toArray(),
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
                'message' => 'GrupoFuncao deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'GrupoFuncao deleted.');
    }
}
