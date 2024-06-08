<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PHPUnit\Framework\MockObject\Builder\Stub;

class CourseController extends Controller
{
    //GET
//GET
    public function index()
    {
        $courses = Course::all();

        if ($courses->isEmpty()){
            $data = [
                'message' => 'No hay asignaturas registradas',
                'status' => 200,
            ];
            return response()->json($data, 404);  // Aquí 404 indica que no se encontraron resultados, lo cual no es un error.
        }
        // Transformar los datos
        $data = $courses->map(function($course) {
            return [
                'id' => $course->id,
                'course_code' => $course->course_code,
                'name' => $course->name,
                'year' => $course->year,
                'semester' => $course->semester,
                'department' => $course->departament,
            ];
        });
        return response()->json($data, 200);
    }

    //POST
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'course_code' => 'required',
            'name' => 'required',
            'year' => 'required',
            'semester' => 'required',
            'departament' => 'required',
        ]);

        if ($validator->fails()) {
            $data = [
                'message' => 'Error en la validación de datos.',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }
        $course = Course::create([
            'course_code' => $request->course_code,
            'name' => $request->name,
            'year' => $request->year,
            'semester' => $request->semester,
            'departament' => $request->departament,
        
        ]);
        if (!$course){
            $data = [
                'message' => 'Error al crear la asignatura.',
                'status' => 500
            ];
            return response()->json($data, 500);
        }
        
        $data = [
            'course' => $course,
            'status' => 201
        ];
        return response()->json($data, 201);
    }

    //GET by ID
    public function show($id)
    {
        $course = Course::find($id);
        if (!$course) {
            $data = [
                'message' => 'Asignatura no encontrada',
                'status' => '404'
            ];
            return response()->json($data, 404);
        }

        $data = [
            'id' => $course->id,
            'course_code' => $course->course_code,
            'name' => $course->name,
            'year' => $course->year,
            'semester' => $course->semester,
            'department' => $course->departament,
            'status' => '200'
        ];
        return response()->json($data, 200);
    }

    //PUT
    public function update(Request $request, $id)
    {
        $course = Course::find($id);

        if(!$course) {
            $data = [
                'message' => 'Asignatura no encontrada.',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $validator = Validator::make($request->all(), [
            'course_code' => 'required',
            'name' => 'required',
            'year' => 'required',
            'semester' => 'required',
            'departament' => 'required',
        ]);

        if ($validator->fails()) {
            $data = [
                'message' => 'Error al enviar la validación de los datos.',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }
        $course->course_code = $request->course_code;
        $course->name = $request->name;
        $course->year = $request->year;
        $course->semester = $request->semester;
        $course->departament = $request->departament;
        $course->save();

        $data = [
            'message' => 'Asignatura editada correctamente.',
            'course' => $course,
            'status' => 200
        ];
        
        return response()->json($data, 200);
        
    }

    public function updatePartial(Request $request, $id)
    {
        $course = Course::find($id);
    
        if (!$course) {
            $data = [
                'message' => 'Asignatura no encontrada.',
                'status' => 404
            ];
            return response()->json($data, 404);
        }
        
        $validator = Validator::make($request->all(), [
            'course_code' => 'max:2',
            'name' => 'max:150',
            'year' => 'in:1,2,3,4,5', // Establece las reglas de validación adecuadas para 'year'
            'semester' => 'in:1,2', // Establece las reglas de validación adecuadas para 'semester'
            'departament' => '',
        ]);
    
        if ($validator->fails()) {
            $data = [
                'message' => 'Error en la validación de los datos.',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }
    
        if ($request->has('course_code')) {
            $course->course_code = $request->course_code;
        }
        if ($request->has('name')) { // Corrección aquí: usar 'name' en lugar de 'surname'
            $course->name = $request->name;
        }
        if ($request->has('year')) {
            $course->year = $request->year;
        }
        if ($request->has('semester')) {
            $course->semester = $request->semester;
        }
        if ($request->has('departament')) {
            $course->departament = $request->departament;
        }
    
        $course->save();
    
        $data = [
            'message' => 'Asignatura actualizada.',
            'status' => 200
        ];
        return response()->json($data, 200);
    }
    
//NO HTTP ----------------------------------------------------------------------------------------------------------
    public function destroy($id)
    {
        $course = Course::find($id);

        if (!$course){
            $data = [
                'message' => 'Asignatura no encontrada.',
                'status' => '404'
            ];
            return response()->json($data, 404);
        }
        $course->delete();

        $data = [
            'message' => 'Asignatura eliminada.',
            'status' => '200'
        ];
        return response()->json($data, 200);
    }
    
    public function create()
    {
        // $course = new Course();
        // return view('course.create', compact('course'));
    }
}    
