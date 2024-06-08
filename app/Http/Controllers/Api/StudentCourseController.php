<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PHPUnit\Framework\MockObject\Builder\Stub;


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
}
