<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
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
            return response()->json([
                'Error' => $e->getMessage()
            ], 401);
        }
    }

    public function store(Request $request)
    {
        try{
            $realState = $this->realState->create($request->all());
            return response()->json([
                'msg' => 'Imóvel cadastrado com sucesso' 
            ], 200);
        }catch(\Exception $e){
            return response()->json([
                'Error' => $e->getMessage()
            ], 401);
        }
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();

        try{
            $realState = $this->realState->findOrFail($id);
            $realState->update($request->all());
            return response()->json([
                'msg' => 'Imóvel atualizado com sucesso',
                'dados' => $realState,
                'data' => $data
            ], 200);
        }catch(\Exception $e){
            return response()->json([
                'Error' => $e->getMessage()
            ], 401);
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
            return response()->json([
                'Error' => $e->getMessage()
            ], 401);
        }
    }
    
}
