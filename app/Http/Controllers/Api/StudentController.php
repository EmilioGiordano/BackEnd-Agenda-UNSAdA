<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\StudentCourse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PHPUnit\Framework\MockObject\Builder\Stub;
use App\Http\Controllers\Api\CarrerPlanController;
use App\Models\CarrerPlan;

class StudentController extends Controller
{
    // GET ALL
    public function index()
    {
        $students = Student::with('carrerPlan')->get();

        if ($students->isEmpty()) {
            $data = [
                'message' => 'No hay estudiantes registrados.',
                'status' => '404',
            ];
            return response()->json($data, 404);
        }

        $data = $students->map(function ($student) {
            return [
                'id' => $student->id,
                'id_user' => $student->id_user,
                'name' => $student->name,
                'surname' => $student->surname,
                'dni' => $student->dni,
                'carrer_plan' => $student->carrerPlan->name ?? null, // Check if carrerPlan exists
            ];
        });

        return response()->json([
            'students' => $data,
            'status' => '200',
        ], 200);
    }

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
    
    //GET by ID con listado de Courses.
    public function showCourses($id)
    {
        
        $student = Student::find($id);
        if (!$student) {
            return response()->json(['message' => 'Estudiante no encontrado', 'status' => '404'], 404);
        }
        $carrerPlan = $student->carrerPlan;
        if (!$carrerPlan) {
            return response()->json(['message'=> 'Plan de carrera no encontrado para el estudiante.']);
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

    //PATCH student_courses->$id_status
    //Cargar ESTADO de ASIGNATURAS del ESTUDIANTE
    public function updateCoursesStatuses(Request $request, $student_id)
    {
        // Validar el ID del estudiante
        $request->validate([
            'updates' => 'required|array',
            'updates.*.course_id' => 'required|integer|exists:courses,id',
            'updates.*.status_id' => 'required|integer|exists:statusname,id',
        ]);

        // Procesar cada actualización
        foreach ($request->updates as $update) {
            // Encontrar la asignatura del estudiante
            $studentCourse = StudentCourse::where('id_estudiante', $student_id)
                                          ->where('id_asignatura', $update['course_id'])
                                          ->first();

            if ($studentCourse) {
                // Actualizar el estado
                $studentCourse->id_status = $update['status_id'];
                $studentCourse->save();
            }
        }

        return response()->json(['message' => 'Statuses updated successfully'], 200);
    }

    //GET student_courses->$id_status
    //Ver ESTADOS de todas las ASIGNATURAS del ESTUDIANTE
    public function getStudentCoursesStatuses($student_id)
    {
        // Validar la existencia del estudiante
        $student = Student::find($student_id);

        if (!$student) {
            return response()->json(['message' => 'Estudiante no encontrado'], 404);
        }

        // Obtener los cursos del estudiante junto con sus estados
        $studentCourses = StudentCourse::where('id_estudiante', $student_id)
                                    ->with('course', 'statusname')
                                    ->get();

      
        $data = $studentCourses->map(function($studentCourse) {
            return [
                'course_id' => $studentCourse->id_asignatura,
                'status_id' => $studentCourse->id_status,
                'course_name' => $studentCourse->course ? $studentCourse->course->name : null,
                'status_name' => $studentCourse->statusname ? $studentCourse->statusname->name : null
            ];
        });

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

    //PATCH
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

    //DELETE
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
    
    //NO SE USA
    public function getCourses($id)
    {
        // Encuentra el estudiante por su ID
        $student = Student::with('studentCourses.course', 'studentCourses.statusname')->find($id);

        if (!$student) {
            return response()->json(['message' => 'Estudiante no encontrado'], 404);
        }

        // Prepara la respuesta
        $data = [
            'id' => $student->id,
            'name' => $student->name,
            'surname' => $student->surname,
            'dni' => $student->dni,
            'carrer_plan' => $student->carrerPlan->name,
            'courses' => $student->studentCourses->map(function($studentCourse) {
                return [
                    'id' => $studentCourse->course->id,
                    'name' => $studentCourse->course->name,
                    'course_code' => $studentCourse->course->course_code,
                    'year' => $studentCourse->course->year,
                    'semester' => $studentCourse->course->semester,
                    'departament' => $studentCourse->course->departament,
                    'status' => optional($studentCourse->statusname)->name
                ];
            })
        ];

        return response()->json($data, 200);
    }
        
}


