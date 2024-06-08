<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PlanCourse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PHPUnit\Framework\MockObject\Builder\Stub;

class PlanCourseController extends Controller
{
    //GET
    public function index()
    {
        $planCourses = PlanCourse::all();

        if ($planCourses->isEmpty()){
            $data = [
                'message' => 'No hay planes de carreras registrados.',
                'status' => 200,

            ];
            return response()->json($data, 404);
        }

        return response()->json($planCourses, 200);
    }
    //GET by ID
    public function show($id)
    {
        $planCourse = PlanCourse::find($id);
        if (!$planCourse){
            $data = [
                'message' => 'Plan de carrera no encontrado.',
                'status' => '404'
            ];
            return response()->json($data, 404);
        }
        $data = [
            'planCourse' => $planCourse,
            'status' => '200'
        ];


        return response()->json($data, 200);
    }
  

    //POST
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_plan' => 'sometimes|nullable',
            'id_asignatura' => 'sometimes|nullable' 
        ]);

        if ($validator->fails()) {
            $data = [
                'message' => 'Error en la validación de datos.',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }
        $planCourse = PlanCourse::create([
            'id_plan' => $request->id_plan,
            'id_asignatura' => $request->id_asignatura
        ]);

        if (!$planCourse){
            $data = [
                'message' => 'Error al crear la correlatividad.',
                'status' => 500
            ];
            return response()->json($data, 500);
        }
        
        $data = [
            'planCourse' => $planCourse,
            'status' => 201
        ];
        return response()->json($data, 201);
    }

   //PUT
    public function update(Request $request, $id)
    {
        $planCourse = PlanCourse::find($id);

        if(!$planCourse) {
            $data = [
                'message' => 'Plan de carrera no encontrado.',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $validator = Validator::make($request->all(), [
            'id_plan' => 'required|exists:carrer_plans,id',
            'id_asignatura' => 'required|exists:courses,id',
        ]);

        if ($validator->fails()) {
            $data = [
                'message' => 'Error al enviar la validación de los datos.',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }
        $planCourse->id_plan = $request->id_plan;
        $planCourse->id_asignatura = $request->id_asignatura;
        $planCourse->save();

        $data = [
            'message' => 'Plan de carrera editado correctamente.',
            'planCourse' => $planCourse,
            'status' => 200
        ];

        return response()->json($data, 200);
        
    }

    public function updatePartial(Request $request, $id)
    {
        $planCourse = PlanCourse::find($id);
    
        if (!$planCourse) {
            $data = [
                'message' => 'Plan de carrera no encontrado.',
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
            $planCourse->name = $request->name;
        }
        if ($request->has('proposal_code')) {
            $planCourse->proposal_code = $request->proposal_code;
        }
  
        $planCourse->save();
    
        $data = [
            'message' => 'Plan de carrera actualizado.',
            'status' => 200
        ];
        return response()->json($data, 200);
    }
    
    //DELETE
    public function destroy($id)
    {
        $planCourse = PlanCourse::find($id);

        if (!$planCourse){
            $data = [
                'message' => 'Plan de carrera no encontrado.',
                'status' => '404'
            ];
            return response()->json($data, 404);
        }
        $planCourse->delete();

        $data = [
            'message' => 'Plan de carrera eliminado.',
            'status' => '200'
        ];
        return response()->json($data, 200);
    }

}    
