<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Prerequisite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PHPUnit\Framework\MockObject\Builder\Stub;

class PrerequisiteController extends Controller
{
    //GET
    public function index()
    {
        $prerequisites = Prerequisite::all();

        if ($prerequisites->isEmpty()){
            $data = [
                'message' => 'No hay correlatividades registradas.',
                'status' => 200,

            ];
            return response()->json($data, 404);
        }

        return response()->json($prerequisites, 200);
    }
    //GET by ID
    public function show($id)
    {
        $prerequisite = Prerequisite::find($id);
        if (!$prerequisite){
            $data = [
                'message' => 'Correlatividad no encontrada.',
                'status' => '404'
            ];
            return response()->json($data, 404);
        }
        $data = [
            'prerequisite' => $prerequisite,
            'status' => '200'
        ];


        return response()->json($data, 200);
    }
  

    //POST
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_plan_asignatura' => 'sometimes|nullable',
            'id_asignaturaCorrelativa' => 'sometimes|nullable' 
        ]);

        if ($validator->fails()) {
            $data = [
                'message' => 'Error en la validación de datos.',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }
        $prerequisite = Prerequisite::create([
            'id_plan_asignatura' => $request->id_plan_asignatura,
            'id_asignaturaCorrelativa' => $request->id_asignaturaCorrelativa
        ]);


        
        if (!$prerequisite){
            $data = [
                'message' => 'Error al crear la correlatividad.',
                'status' => 500
            ];
            return response()->json($data, 500);
        }
        
        $data = [
            'prerequisite' => $prerequisite,
            'status' => 201
        ];
        return response()->json($data, 201);
    }

   //PUT
    public function update(Request $request, $id)
    {
        $prerequisite = Prerequisite::find($id);

        if(!$prerequisite) {
            $data = [
                'message' => 'Correlatividad no encontrado.',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $validator = Validator::make($request->all(), [
            'id_plan_asignatura' => 'required|exists:plan_courses,id',
            'id_asignaturaCorrelativa' => 'required|exists:courses,id',
        ]);

        if ($validator->fails()) {
            $data = [
                'message' => 'Error al enviar la validación de los datos.',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }
        $prerequisite->id_plan_asignatura = $request->id_plan_asignatura;
        $prerequisite->id_asignaturaCorrelativa = $request->id_asignaturaCorrelativa;
        $prerequisite->save();

        $data = [
            'message' => 'Correlatividad editada correctamente.',
            'prerequisite' => $prerequisite,
            'status' => 200
        ];
        
        return response()->json($data, 200);
        
    }

    public function updatePartial(Request $request, $id)
    {
        $prerequisite = Prerequisite::find($id);
    
        if (!$prerequisite) {
            $data = [
                'message' => 'Correlatividad no encontrada.',
                'status' => 404
            ];
            return response()->json($data, 404);
        }
        
        $validator = Validator::make($request->all(), [
            'name' => 'max:120',
            'proposal_code' => 'max:10',
        ]);
    
        if ($validator->fails()) {
            $data = [
                'message' => 'Error en la validación de los datos.',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }
    
    
        if ($request->has('name')) { // Corrección aquí: usar 'name' en lugar de 'surname'
            $prerequisite->name = $request->name;
        }
        if ($request->has('proposal_code')) {
            $prerequisite->proposal_code = $request->proposal_code;
        }
  
        $prerequisite->save();
    
        $data = [
            'message' => 'Correlatividad actualizada.',
            'status' => 200
        ];
        return response()->json($data, 200);
    }
    
    //DELETE
    public function destroy($id)
    {
        $prerequisite = Prerequisite::find($id);

        if (!$prerequisite){
            $data = [
                'message' => 'Correlatividad no encontrado.',
                'status' => '404'
            ];
            return response()->json($data, 404);
        }
        $prerequisite->delete();

        $data = [
            'message' => 'Correlatividad eliminada.',
            'status' => '200'
        ];
        return response()->json($data, 200);
    }

}    
