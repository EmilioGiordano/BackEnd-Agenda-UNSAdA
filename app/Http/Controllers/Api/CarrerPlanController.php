<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CarrerPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PHPUnit\Framework\MockObject\Builder\Stub;

class CarrerPlanController extends Controller
{
    //GET
    public function index()
    {
        $carrerPlans = CarrerPlan::all();
    
        if ($carrerPlans->isEmpty()) {
            return response()->json([
                'message' => 'No hay planes de carreras registrados.',
                'status' => 200,
            ], 200);  
        }
    
        // Transformar los datos
        $data = $carrerPlans->map(function($carrerPlan) {
            return [
                'id' => $carrerPlan->id,
                'name' => $carrerPlan->name,
                'proposal_code' => $carrerPlan->proposal_code,
                
            ];
        });
    
        return response()->json($data, 200);
    }
    //GET by ID
    public function show($id)
    {
        $carrerPlan = CarrerPlan::find($id);
        if (!$carrerPlan) {
            $data = [
                'message' => 'Plan de carrera no encontrado.',
                'status' => '404'
            ];
            return response()->json($data, 404);
        }

        $data = [
            'id' => $carrerPlan->id,
            'name' => $carrerPlan->name,
            'proposal_code' => $carrerPlan->proposal_code,
            'status' => '200'
        ];
        return response()->json($data, 200);
    }
  
    //POST
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:120',
            'proposal_code' => 'required|max:10',
        ]);

        if ($validator->fails()) {
            $data = [
                'message' => 'Error en la validación de datos.',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }
        $carrerPlan = CarrerPlan::create([
            'name' => $request->name,
            'proposal_code' => $request->proposal_code
        ]);

        if (!$carrerPlan){
            $data = [
                'message' => 'Error al crear el plan de carrera.',
                'status' => 500
            ];
            return response()->json($data, 500);
        }
        
        $data = [
            'carrerPlan' => $carrerPlan,
            'status' => 201
        ];
        return response()->json($data, 201);
    }
   //PUT
    public function update(Request $request, $id)
    {
        $carrerPlan = CarrerPlan::find($id);

        if(!$carrerPlan) {
            $data = [
                'message' => 'Plan de carrera no encontrado.',
                'status' => 404
            ];
            return response()->json($data, 404);
        }
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:120',
            'proposal_code' => 'required|max:10',
        ]);
        if ($validator->fails()) {
            $data = [
                'message' => 'Error al enviar la validación de los datos.',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }
        $carrerPlan->name = $request->name;
        $carrerPlan->proposal_code = $request->proposal_code;
        $carrerPlan->save();

        $data = [
            'message' => 'Plan de carrera editado correctamente.',
            'carrerPlan' => $carrerPlan,
            'status' => 200
        ];
        return response()->json($data, 200);
    }

    public function updatePartial(Request $request, $id)
    {
        $carrerPlan = CarrerPlan::find($id);
    
        if (!$carrerPlan) {
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
            $carrerPlan->name = $request->name;
        }
        if ($request->has('proposal_code')) {
            $carrerPlan->proposal_code = $request->proposal_code;
        }
        $carrerPlan->save();

        $data = [
            'message' => 'Plan de carrera actualizado.',
            'status' => 200
        ];
        return response()->json($data, 200);
    }
    
    //DELETE
    public function destroy($id)
    {
        $carrerPlan = CarrerPlan::find($id);

        if (!$carrerPlan){
            $data = [
                'message' => 'Plan de carrera no encontrado.',
                'status' => '404'
            ];
            return response()->json($data, 404);
        }
        $carrerPlan->delete();

        $data = [
            'message' => 'Plan de carrera eliminado.',
            'status' => '200'
        ];
        return response()->json($data, 200);
    }


    public function getCourses($id)
    {
        // Encuentra el plan de carrera por su ID
        $carrerPlan = CarrerPlan::with('planCourses.course')->find($id);

        if (!$carrerPlan) {
            return response()->json(['message' => 'Plan no encontrado'], 404);
        }

        // Prepara la respuesta
        $data = [
            'id' => $carrerPlan->id,
            'plan_name' => $carrerPlan->name,
            'courses' => $carrerPlan->planCourses->map(function($planCourse) {
                return [
                    'id' => $planCourse->course->id,
                    'name' => $planCourse->course->name,
                    'course code' =>$planCourse->course->course_code,
                    'year' => $planCourse->course->year,
                    'semester' => $planCourse->course->semester,
                    'departament' => $planCourse->course->departament
                ];
            })
        ];

        return response()->json($data, 200);
    }


}    
