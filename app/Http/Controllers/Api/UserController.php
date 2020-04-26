<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Messagens\ApiMessages;
use App\User;

class UserController extends Controller
{
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function index()
    {
        $this->user = $this->user->paginate('10');
        return response($this->user, 200);
    }

    public function show($id)
    {
        try{
            $this->user = $this->user->findOrFail($id);
            return response()->json([
                'dados' => $this->user
            ], 200);
        }catch(\Exception $e){
            $messege = new ApiMessages($this->user);
            return response()->json($messege->getMessage(), 401);
        }
    }

    public function store(UserRequest $request){
        $data = $request->all();

        try{
            $this->user->create($data);
            return response()->json([
                'msg' => 'Criado com sucesso'
            ], 200);

        }catch(\Exception $e){
            $message = new ApiMessages($e->getMessage());
            return response()->json($message->getMessage(), 401);
        }
    }
    public function update(UserRequest $request, $id)
    {
        $data = $request->all();
        if(!$request->has('password') || $request->get('password')){
            $data['password'] = bcrypt($data['password']);
        }else{
            unset($data['password']);
        }
        
        try{
            $this->user = $this->findOrFail($id);
            $this->user->update($request->all());
            return response()->json([
                'msg' => 'Update realizado com sucesso'
            ], 200);
        }catch(\Exception $e){
            $message = new ApiMessages($e->getMessage());
            return response()->json($message->getMessage(), 401);
        }
    }

    public function destroy($id)
    {
        try{
            $this->user = $this->user->findorFail($id);
            $this->user->delete();
            return response()->json([
                'msg' => 'Usuario deletado com sucesso'
            ]);
        }catch(\Exception $e){
            $message = new ApiMessages($e->getMessage());
            return response()->json($message->getMessage(), 401);
        }

    }
}
