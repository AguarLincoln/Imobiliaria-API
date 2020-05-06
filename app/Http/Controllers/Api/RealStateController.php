<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RealStateRequest;
use App\Messagens\ApiMessages;
use App\RealState;
use Illuminate\Http\Request;

class RealStateController extends Controller
{
    private $realState;

    public function __construct(RealState $realState)
    {
        $this->realState = $realState;       
    }

    public function index()
    {
        $this->realState = $this->realState->paginate(10);
        return response($this->realState, 200);
    }

    public function show($id)
    {
        try{
            $realState = $this->realState->findOrFail($id);
            return response()->json([
                'msg' => 'Imóvel mostrado com sucesso',
                'dados' => $realState 
            ], 200);
        }catch(\Exception $e){
            $message = new ApiMessages($e->getMessage());
            return response()->json($message->getMessage(), 401);
        }
    }

    public function store(RealStateRequest $request)
    {
        $data = $request->all();

        try{
            $realState = $this->realState->create($data);

            if(isset($data['realState']) && count($data['categories']))
                $realState()->categories()->sync($data['categories']);
            
                return response()->json([
                'msg' => 'Imóvel cadastrado com sucesso' 
            ], 200);
        }catch(\Exception $e){
            $message = new ApiMessages($e->getMessage());
            return response()->json($message->getMessage(), 401);
        }
    }

    public function update(RealStateRequest $request, $id)
    {
        $data = $request->all();

        try{
            $realState = $this->realState->findOrFail($id);
            $realState->update($data);

            if(isset($data['realState']) && count($data['categories']))
                $realState()->categories()->sync($data['categories']);
            
            return response()->json([
                'msg' => 'Imóvel atualizado com sucesso',
                'dados' => $realState,
                'data' => $data
            ], 200);
        }catch(\Exception $e){
            $message = new ApiMessages($e->getMessage());
            return response()->json($message->getMessage(), 401);
        }
    }

    public function destroy($id)
    {
        try{
            $realState = $this->realState->findOrFail($id);
            $realState->delete();
            return response()->json([
                'msg' => 'Imóvel deletado com sucesso'
            ], 200);
        }catch(\Exception $e){
            $message = new ApiMessages($e->getMessage());
            return response()->json($message->getMessage(), 401);
        }
    }
    
}
