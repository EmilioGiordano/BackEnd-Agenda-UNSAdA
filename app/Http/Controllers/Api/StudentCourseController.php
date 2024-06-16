<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PHPUnit\Framework\MockObject\Builder\Stub;
use Illuminate\Support\Facades\DB;


class StudentCourseController extends Controller
{
    public function show($id)
    {
        $student = Student::find($id);
        $plan = $student->id_plan;

        if (!$student) {
            return response()->json(['message'=> 'Estudiante no encontrado.'], 404);
        }
        $data = [
            'id'=> $student->id,
            'name' =>$student->name,
            'surname' =>$student->surname
        ];
        return response()->json($data, 200);
    }

    
    public function executeQuery()
    {
        DB::statement('CREATE TEMPORARY TABLE temp_students AS SELECT ID, id_plan_carrera FROM Students;');
        DB::statement('CREATE TEMPORARY TABLE temp_courses_by_plan AS SELECT id_plan, id_asignatura FROM plan_courses;');
        DB::statement('INSERT INTO student_courses (id_estudiante, id_asignatura)
            SELECT s.ID as id_estudiante, p.id_asignatura
            FROM temp_students s
            JOIN temp_courses_by_plan p ON s.id_plan_carrera = p.id_plan;');
        DB::statement('DROP TEMPORARY TABLE temp_students;');
        DB::statement('DROP TEMPORARY TABLE temp_courses_by_plan;');

        return response()->json(['message' => 'Query executed successfully'], 200);
    }
}
