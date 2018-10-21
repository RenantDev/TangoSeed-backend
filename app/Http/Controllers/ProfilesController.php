<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\ProfileCreateRequest;
use App\Http\Requests\ProfileUpdateRequest;
use App\Repositories\ProfileRepository;
use App\Validators\ProfileValidator;


class ProfilesController extends Controller
{

    /**
     * @var ProfileRepository
     */
    protected $repository;

    /**
     * @var ProfileValidator
     */
    protected $validator;

    public function __construct(ProfileRepository $repository, ProfileValidator $validator)
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
        $profiles = $this->repository->findWhere(['user_id' => Auth::user()->id]);

        if (request()->wantsJson()) {
            return response()->json([
                'data' => $profiles,
            ]);
        }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  ProfileCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(ProfileCreateRequest $request)
    {

        
        $profile = array_merge($request->all(), ['user_id' => Auth::user()->id]);

        try {

            $this->validator->with($profile)->passesOrFail(ValidatorInterface::RULE_CREATE);

            $profile = $this->repository->create($profile);

            $response = [
                'message' => 'Profile created.',
                'data'    => $profile->toArray(),
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
        $profile = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $profile,
            ]);
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ProfileUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     */
    public function update(ProfileUpdateRequest $request)
    {

        // Busca o ID do pefil no banco de dados e retorna uma array
        $profileArray = DB::table('profiles')
        ->where('user_id', '=', Auth::user()->id)
        ->select(['id'])
        ->get()
        ->toArray();

        // Extrai o ID do perfil da array
        $idProfile = $profileArray[0]->id;

        // Atualiza as informações do perfil
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $profile = $this->repository->update($request->all(), $idProfile);

            $response = [
                'message' => 'Profile updated.',
                'data'    => $profile->toArray(),
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

}
