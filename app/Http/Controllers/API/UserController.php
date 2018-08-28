<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\UserFormRequest;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        return response()->json($users);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|unique:users,email',
            'password' => 'required'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 400);
        }

        $user = User::create($request->all());

        return response()->json(['message' => 'Usuário cadastrado com sucesso!', 'data' => $user], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);

        if(!$user){
            return response()->json(['message' => 'Usuário não encontrado!'], 404);
        }

        return response()->json($user);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'unique:users,email',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 400);
        }

        $user = User::find($id);

        if(!$user){
            return response()->json(['message' => 'Usuário não encontrado!'], 404);
        }

        $user->update($request->all());

        return response()->json(['message' => 'Dados atualizados com sucesso.'], 202);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);

        if(!$user){
            return response()->json(['message' => 'Usuário não encontrado!'], 404);
        }

        $user->delete();

        return response()->json(['message' => 'Dados deletetados com sucesso'], 202);
    }

    public function login()
    {
        if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){
            $user = Auth::user();
            $success['token'] = $user->createToken('LaravelApi')->accessToken;
            return response()->json(['success' => $success], 200);
        }else{
            return response()->json(['error' => 'Unauthorised'], 401);
        }
    }

    public function register(Request $request)
    {
        $data               = $request->all();
        $data['password']   = bcrypt($data['password']);
        $user               = User::create($data);
        $success['token']   = $user->createToken('LaravelApi')->accessToken;
        $success['name']    = $user->name;
        return response()->json(['success' => $success], 200);
    }
}
