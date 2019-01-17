<?php

namespace App\Http\Controllers\Admin;

use App\Entities\UserRGroup;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginCreateRequest;
use App\Http\Requests\LoginUpdateRequest;
use App\Repositories\LoginRepository;
use App\Validators\LoginValidator;
use Illuminate\Http\Request;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;

class LoginsController extends Controller
{

    /**
     * @var LoginRepository
     */
    protected $repository;

    /**
     * @var LoginValidator
     */
    protected $validator;

    public function __construct(LoginRepository $repository, LoginValidator $validator)
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
        $logins = $this->repository->paginate($limit, ['id', 'name', 'email', 'status']);

        if (request()->wantsJson()) {
            return response()->json($logins);
        }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  LoginCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(LoginCreateRequest $request)
    {
        try {

            $request->merge(['remember_token' => str_random(10)]);

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $request->merge(['password' => bcrypt($request->password)]);

            $login = $this->repository->create($request->all());

            $data = $login->toArray();

            UserRGroup::create([
                'user_id' => $data['id'],
                'group_id' => $request->input('group'),
            ]);

            $response = [
                'message' => __('admin.users.create.success'),
                'data' => $login->toArray(),
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
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $login = $this->repository->find($id, ['id', 'name', 'email', 'created_at', 'updated_at']);

            if (request()->wantsJson()) {
                return response()->json([
                    'data' => $login,
                ]);
            }
        } catch (\Exception $e) {
            if (request()->wantsJson()) {
                return response()->json([
                    'error' => true,
                    'message' => __('admin.users.info.error'),
                ]);
            }
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  LoginUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     */
    public function update(LoginUpdateRequest $request, $id)
    {

        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            if (isset($request->password)) {
                $request->merge(['password' => bcrypt($request->password)]);
            }

            $login = $this->repository->update($request->all(), $id);

            $response = [
                'message' => __('admin.users.update.success'),
                'data' => $login->toArray(),
            ];

            if ($request->wantsJson()) {
                return response()->json($response);
            }

        } catch (ValidatorException $e) {

            if ($request->wantsJson()) {
                return response()->json([
                    'error' => true,
                    'message' => __('admin.users.update.error'),
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

        try {
            $deleted = $this->repository->delete($id);
            if (request()->wantsJson()) {
                return response()->json([
                    'message' => __('admin.users.delete.success'),
                    'deleted' => $deleted,
                ]);
            }
        } catch (\Exception $e) {
            if (request()->wantsJson()) {
                return response()->json([
                    'error' => true,
                    'message' => __('admin.users.delete.error'),
                ]);
            }
        }

    }
}
