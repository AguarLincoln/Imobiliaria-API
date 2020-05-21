<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Messagens\ApiMessages;
use App\User;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Validator;

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
            $user = $this->user->with('profile')->findOrFail($id);
            //$user->profile->social_networks = unserialize($user->profile->social_networks);
            
            return response()->json([
                'data' => $user
            ], 200);
        }catch(\Exception $e){
            $messege = new ApiMessages($this->user);
            return response()->json($messege->getMessage(), 401);
        }
    }

    public function store(UserRequest $request){
        
        $data = $request->all();
        
        if(!$request->has('password') || !$request->get('password')){
            $data['password'] = bcrypt($data['password']);
            $message = new ApiMessages('É necessario digitar uma senha pro usuario...');
            return response()->json($message->getMessage(), 401);
        }

        Validator::make($data, [
            'phone' => 'required',
            'social_networks'=> 'required'
        ])->validate();

        try{

            $data['password'] = bcrypt($data['password']);
            
            $user = $this->user->create($data);
            $user->profile()->create([
                'phone' => $data['phone'],
                'social_networks' => $data['social_networks'],

            ]);
            $user->profile->social_network = serialize($user->profile->social_network);
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
        dd($request);
        $data = $request->all();
        if(!$request->has('password') || !$request->get('password')){
            $data['password'] = bcrypt($data['password']);
        }else{
            unset($data['password']);
        }
        
        Validator::make($data, [
            'profile.phone' => 'required',
            'profile.social_networks'=> 'required'
        ])->validate();

        try{
            $profile = $data['profile'];
            $profile['social_networks'] = serialize($profile['social_networks']);
            $user = $this->user->findOrFail($id);
            $user->update($request->all());

            $user->profile()->update($profile);
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
