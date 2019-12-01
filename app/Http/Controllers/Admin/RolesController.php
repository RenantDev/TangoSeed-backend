<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use function GuzzleHttp\describe_type;
use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\RoleCreateRequest;
use App\Http\Requests\RoleUpdateRequest;
use App\Repositories\RoleRepository;
use App\Validators\RoleValidator;


class RolesController extends Controller
{

    /**
     * @var RoleRepository
     */
    protected $repository;

    /**
     * @var RoleValidator
     */
    protected $validator;

    public function __construct(RoleRepository $repository, RoleValidator $validator)
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

        $this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
        $roles = $this->repository->paginate($limit, ['id', 'category_id', 'title', 'slug', 'scope']);

        if (request()->wantsJson()) {
            return response()->json($roles);
        }
    }

    // Categoria de funções
    public function list()
    {

        // Busca as funcoes no banco de dados
        $roles = $this->repository->all(['id', 'category_id', 'title', 'description', 'slug', 'scope', 'status']);

        // Cria uma array com os grupos de funcao e suas funcoes
        $result = array();
        $i = (int) 0;
        foreach ($roles AS $role) {
            if ($role['category_id'] == 1 and $role['id'] != 1 and $role['id'] != 2) {
                foreach ($roles AS $role_child) {
                    if ($role_child['category_id'] == $role['id'] and $role_child['status'] == 1) {
                        $result[$role['title']][$i] = array(
                            'id' => $role_child['id'],
                            'title' => $role_child['title'],
                            'description' => $role_child['description']
                        );
                        $i++;
                    }
                }
            }
            $i = 0;
        }

        // Retorna o resultado da pesquisa
        if (request()->wantsJson()) {
            return response()->json($result);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param RoleCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(RoleCreateRequest $request)
    {
        try {
            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);
            $role = $this->repository->create($request->all());
            $response = [
                'message' => __('admin.roles.create.success'),
                'data' => $role->toArray(),
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
            $role = $this->repository->find($id);

            if (request()->wantsJson()) {
                return response()->json([
                    'data' => $role,
                ]);
            }
        } catch (\Exception $e) {
            if (request()->wantsJson()) {
                return response()->json([
                    'error' => true,
                    'message' => __('admin.roles.info.error')
                ]);
            }
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param RoleUpdateRequest $request
     * @param string $id
     *
     * @return Response
     */
    public function update(RoleUpdateRequest $request, $id)
    {

        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $role = $this->repository->update($request->all(), $id);
            $response = [
                'message' => __('admin.roles.update.success'),
                'data' => $role->toArray(),
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
                    'message' => __('admin.roles.delete.success'),
                    'deleted' => $deleted,
                ]);
            }
        } catch (\Exception $e) {
            if (request()->wantsJson()) {
                return response()->json([
                    'error' => true,
                    'message' => __('admin.roles.delete.error'),
                ]);
            }
        }
    }
}
