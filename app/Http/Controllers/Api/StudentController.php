<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PHPUnit\Framework\MockObject\Builder\Stub;
use App\Http\Controllers\Api\CarrerPlanController;
use App\Models\CarrerPlan;

class StudentController extends Controller
{
    //GET ALL
    public function index()
    {
        $students = Student::all();

        if ($students->isEmpty()){
            $data = [
                'message' => 'No hay estudiantes registrados',
                'status' => 200,

        ];
            return response()->json($data, 404);
        }

        return response()->json($students, 200);
    }
        //GET by ID
        //GET ANTIGUO, devuelve todo el objeto studen(incluye datos que no nos interesan)
        // public function show($id)
        // {
        //     $student = Student::find($id);
    
        //     if (!$student){
        //         $data = [
        //             'message' => 'Estudiante no encontrado',
        //             'status' => '404'
        //         ];
        //         return response()->json($data, 404);
        //     }
        //     $data = [
        //         'student' => $student,
        //         'status' => '200'
        //     ];
        //     return response()->json($data, 200);
        // }
    
        //GET by ID 
        public function show($id)
        {
            $student = Student::find($id);
    
            if (!$student){
                $data = [
                    'message' => 'Estudiante no encontrado',
                    'status' => '404'
                ];
                return response()->json($data, 404);
            }
            $data = [
                'id'=> $student->id,
                'id_user'=>$student->id_user,
                'name' => $student->name,
                'surname' => $student->surname,
                'dni' => $student->dni,
                'carrer plan' => $student->carrerPlan->name,
                'status' => '200'
            ];
    
        return response()->json($data, 200);
        }
    
        //GET by ID and PLAN->COURSE::LIST
        public function showCourses($id)
        {
            $student = Student::find($id);
            if (!$student) {
                return response()->json(['message' => 'Estudiante no encontrado', 'status' => '404'], 404);
            }
            $carrerPlan = $student->carrerPlan;
            if (!$carrerPlan) {
                return response()->jason(['message'=> 'Plan de carrera no encontrado para el estudiante.']);
            }
    
            if (!$student){
                $data = [
                    'message' => 'Estudiante no encontrado',
                    'status' => '404'
                ];
                return response()->json($data, 404);
            }
            $data = [
                'id'=> $student->id,
                'name' => $student->name,
                'surname' => $student->surname,
                'dni' => $student->dni,
                'carrer plan' => $student->carrerPlan->name,
                'courses'=> $carrerPlan->planCourses->map(function($planCourse){
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
    //POST
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:75',
            'surname' => 'required|max:75',
            'dni' => 'required|digits:8',
            'id_user' => 'sometimes|nullable|exists:users,id',
            'id_plan_carrera' => 'sometimes|nullable|exists:carrer_plans,id' 

        ]);

        if ($validator->fails()) {
            $data = [
                'message' => 'Error en la validación de datos.',
                'errors' => $validator->errors(),
                'status' => 400
            ];  
            return response()->json($data, 400);
        }
        $student = Student::create([
            'name' => $request->name,
            'surname' => $request->surname,
            'dni' => $request->dni,
            'id_user'=>$request->id_user,
            'id_plan_carrera'=>$request->id_plan_carrera
        ]);
        if (!$student){
            $data = [
                'message' => 'Error al crear el estudiante.',
                'status' => 500
            ];
            return response()->json($data, 500);
        }
        
        $data = [
            'student' => $student,
            'status' => 201
        ];
        return response()->json($data, 201);
    }



    
    //PUT
    public function update(Request $request, $id)
    {
        $student = Student::find($id);

        if(!$student) {
            $data = [
                'message' => 'Estudiante no encontrado.',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|max:75',
            'surname' => 'required|max:75',
            'dni' => 'required|digits:8',
            'id_user' => 'sometimes|nullable|exists:users,id',
            'id_plan_carrera' => 'sometimes|nullable|exists:carrer_plans,id' 

        ]);

        if ($validator->fails()) {
            $data = [
                'message' => 'Error al enviar la validación de los datos.',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }
        $student->name = $request->name;
        $student->surname = $request->surname;
        $student->dni = $request->dni;
        $student->id_user = $request->id_user;
        $student->id_plan_carrera = $request->id_plan_carrera;

        $student->save();

        $data = [
            'message' => 'Estudiante editado correctamente.',
            'student' => $student,
            'status' => 200
        ];
        
        return response()->json($data, 200);
        
    }

    public function updatePartial(Request $request, $id)
    {
    
        $student = Student::find($id);

        if (!$student) {
            $data = [
                'message' => 'Estudiante no encontrado.',
                'status' => 404
            ];
            return response()->json($data, 404);
        }
       
        
        $validator = Validator::make($request->all(), [
            'name' => 'max:75',
            'surname' => 'max:75',
            'dni' => 'digits:8',
        ]);
        if ($validator->fails()) {
            $data = [
                'message' => 'Error en la validación de los datos.',
                'errors' => $validator->errors(),
                'status' => 404
            ];
            return response()->json($data, 400);
        }
        if($request->has('name')){
            $student->name = $request->name;
        }
        if($request->has('surname')){
            $student->surname = $request->surname;
        }
        if($request->has('dni')){
            $student->dni = $request->dni;
        }
        if($request->has('id_user')){
            $student->id_user = $request->id_user;
        }
        if($request->has('id_plan_carrera')){
            $student->id_plan_carrera = $request->id_plan_carrera;
        }
        $student->save();
        $data = [
            'message' => 'Estudiante actualizado.',
            'status' => 200
        ];
        return response()->json($data, 200);
        
    }

    public function destroy($id)
    {
        $student = Student::find($id);

        if (!$student){
            $data = [
                'message' => 'Estudiante no encontrado.',
                'status' => '404'
            ];
            return response()->json($data, 404);
        }
        $student->delete();

        $data = [
            'message' => 'Estudiante eliminado.',
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
