<?php

namespace App\Http\Controllers\Api\Acl;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\FuncaoCreateRequest;
use App\Http\Requests\FuncaoUpdateRequest;
use App\Repositories\Api\Acl\FuncaoRepository;
use App\Validators\Api\Acl\FuncaoValidator;


class FuncoesController extends Controller
{

    /**
     * @var FuncaoRepository
     */
    protected $repository;

    /**
     * @var FuncaoValidator
     */
    protected $validator;

    public function __construct(FuncaoRepository $repository, FuncaoValidator $validator)
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
        $funcaos = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $funcaos,
            ]);
        }

        return view('funcaos.index', compact('funcaos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  FuncaoCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(FuncaoCreateRequest $request)
    {

        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $funcao = $this->repository->create($request->all());

            $response = [
                'message' => 'Funcao created.',
                'data'    => $funcao->toArray(),
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
        $funcao = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $funcao,
            ]);
        }

        return view('funcaos.show', compact('funcao'));
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

        $funcao = $this->repository->find($id);

        return view('funcaos.edit', compact('funcao'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  FuncaoUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     */
    public function update(FuncaoUpdateRequest $request, $id)
    {

        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $funcao = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'Funcao updated.',
                'data'    => $funcao->toArray(),
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
                'message' => 'Funcao deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'Funcao deleted.');
    }
}
