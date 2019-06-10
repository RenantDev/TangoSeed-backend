<?php

namespace App\Http\Controllers\Admin;

use App\Entities\UserRGroup;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginCreateRequest;
use App\Http\Requests\LoginUpdateRequest;
use App\Repositories\LoginRepository;
use App\Validators\LoginValidator;
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
            // Busca os dados do usuário
            $login = $this->repository->find($id, ['id', 'name', 'email', 'status', 'created_at', 'updated_at']);

            // Busca o grupo de usuários que ele faz parte
            $idUserGroup = UserRGroup::where('user_id', $id)->firstOrFail();

            // Unifica as duas arrays de pesquisa
            $data = array_merge($login->toArray(), ['group' => $idUserGroup->group_id]);

            // Retorna um JSON apenas se for solicitado o JSON
            if (request()->wantsJson()) {
                // Converte em JSON
                return response()->json([
                    'data' => $data,
                ]);
            }
        } catch (\Exception $e) {
            // Retorna um JSON apenas se for solicitado o JSON
            if (request()->wantsJson()) {
                // Converte em JSON
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

            // Valida as informaçoes fornecidas pelo formulario
            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            if(isset($request->user_id) or isset($request->password) or isset($request->email) or isset($request->name) or isset($request->group)){

                // Caso exista uma alteração de password ele é criptografado
                if (isset($request->password)) {
                    $request->merge(['password' => bcrypt($request->password)]);
                }

                // Atualiza informações do usuário
                $login = $this->repository->update($request->all(), $id);

                // Se existir uma alteração de grupo
                if(isset($request->group)){
                    // Atualiza grupo do usuário
                    UserRGroup::where('user_id', $id)
                        ->update(['group_id' => (int) $request->group]);

                    // Unifica as duas arrays de pesquisa
                    $data = array_merge($login->toArray(), ['group' => (int) $request->group]);
                } else{
                    // Retorna atualização sem grupo
                    $data = array_merge($login->toArray(), ['group' => 0]);
                }

                // Monta array de retorno
                $response = [
                    'message' => __('admin.users.update.success'),
                    'data' => $data

                ];

                // Retorna um json
                if ($request->wantsJson()) {
                    return response()->json($response);
                }
            } else{
                // Monta array de retorno
                $response = [
                    'message' => __('Nenhuma informação foi alterada!'),
                ];

                // Retorna um json
                if ($request->wantsJson()) {
                    return response()->json($response);
                }
            }

        } catch (ValidatorException $e) {

            // Retorna um JSON com o erro
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
