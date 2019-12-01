<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\GroupCreateRequest;
use App\Http\Requests\GroupUpdateRequest;
use App\Repositories\GroupRepository;
use App\Validators\GroupValidator;
use Illuminate\Http\Request;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;

use App\Entities\GroupRRole;

class GroupsController extends Controller
{

    /**
     * @var GroupRepository
     */
    protected $repository;

    /**
     * @var GroupValidator
     */
    protected $validator;

    public function __construct(GroupRepository $repository, GroupValidator $validator)
    {
        $this->repository = $repository;
        $this->validator = $validator;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        // Define a quantidade de itens na pagina
        $limit = request('limit', null);

        // Verifica e lista os itens da tabela
        $this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
        $groups = $this->repository->paginate($limit, ['id', 'title', 'description', 'status']);

        if (request()->wantsJson()) {
            return response()->json($groups);
        }
    }

    function list()
    {
        $groups = $this->repository->all(['id', 'title']);

        if (request()->wantsJson()) {
            return response()->json($groups);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param GroupCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(GroupCreateRequest $request)
    {
        try {
            // verifica se os campos são validos
            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            // registra o novo grupo
            $group = $this->repository->create($request->all());

            // define as funções do novo grupo
            $roles = $request->toArray()['roles'];
            if ($roles != null) {
                foreach ($roles as $value) {
                    GroupRRole::create([
                        'role_id' => $value,
                        'group_id' => $group->id
                    ]);
                }
            }

            $response = [
                'message' => __('admin.groups.create.success'),
                'data' => $group->toArray()
            ];

            if ($request->wantsJson()) {
                return response()->json($response);
            }
        } catch (ValidatorException $e) {
            if ($request->wantsJson()) {
                return response()->json([
                    'error' => true,
                    'message' => $e->getMessageBag()
                ]);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $group = $this->repository->find($id);

            if (request()->wantsJson()) {
                return response()->json([
                    'data' => $group,
                ]);
            }
        } catch (\Exception $e) {
            if (request()->wantsJson()) {
                return response()->json([
                    'error' => true,
                    'message' => __('admin.groups.info.error'),
                ]);
            }
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param GroupUpdateRequest $request
     * @param string $id
     *
     * @return Response
     */
    public function update(GroupUpdateRequest $request, $id)
    {

        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $group = $this->repository->update($request->all(), $id);

            $response = [
                'message' => __('admin.groups.update.success'),
                'data' => $group->toArray(),
            ];

            if ($request->wantsJson()) {
                return response()->json($response);
            }
        } catch (ValidatorException $e) {
            if ($request->wantsJson()) {
                return response()->json([
                    'error' => true,
                    'message' => $e->getMessageBag(),
                ]);
            }

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $deleted = $this->repository->delete($id);
            if (request()->wantsJson()) {
                return response()->json([
                    'deleted' => $deleted,
                    'message' => __('admin.groups.delete.success'),
                ]);
            }
        } catch (\Exception $e) {
            if (request()->wantsJson()) {
                return response()->json([
                    'error' => true,
                    'message' => __('admin.groups.delete.error'),
                ]);
            }
        }

    }
}
