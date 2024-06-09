<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\RequestException;

use App\Models\PlanCourse;
use App\Models\Course;
use App\Models\CarrerPlan;





class PlanCourseControllerView extends Controller
{
    public function index()
    {
        // Ordenar primero por 'id_plan' de menor a mayor y luego por 'id_asignatura' de menor a mayor
        $planCourses = PlanCourse::with('carrerPlan')
            ->orderBy('id_plan', 'asc') // Ordenar por 'id_plan'
            ->orderBy('id_asignatura', 'asc') // Ordenar por 'id_asignatura'
            ->paginate();

        return view('plan-course.index', compact('planCourses'))
            ->with('i', (request()->input('page', 1) - 1) * $planCourses->perPage());
    }


    public function create()
    {
        $planCourse = new PlanCourse();
        $courses = Course::pluck('name', 'id');
        $carrerPlans = CarrerPlan::pluck('name', 'id');

        return view('plan-course.create', compact('planCourse', 'courses', 'carrerPlans'));
    }


    public function store(Request $request)
    {
        request()->validate(PlanCourse::$rules);

        $planCourse = PlanCourse::create($request->all());

        return redirect()->route('plan-courses.index')
            ->with('success', 'PlanCourse created successfully.');
    }

    public function show($id)
    {
        $planCourse = PlanCourse::find($id);

        return view('plan-course.show', compact('planCourse'));
    }

    public function edit($id)
    {
        $planCourse = PlanCourse::find($id);
        $courses = Course::pluck('name', 'id');
        $carrerPlans = CarrerPlan::pluck('name', 'id');

        return view('plan-course.edit', compact('planCourse', 'courses', 'carrerPlans'));
    }

    public function update(Request $request, PlanCourse $planCourse)
    {
        request()->validate(PlanCourse::$rules);

        $planCourse->update($request->all());

        return redirect()->route('plan-courses.index')
            ->with('success', 'PlanCourse updated successfully');
    }

    public function destroy($id)
    {
        $planCourse = PlanCourse::find($id)->delete();

        return redirect()->route('plan-courses.index')
            ->with('success', 'PlanCourse deleted successfully');
    }
}




// MULTIPLE INSERT, queda por las dudas, no anda todavia
// public function store(Request $request)
// {
//     request()->validate(PlanCourse::$rules);

//     // Obtener el id_plan del formulario
//     $id_plan = $request->input('id_plan');

//     // Obtener los id_asignatura del formulario (asumo que son enviados como un array)
//     $id_asignaturas = $request->input('id_asignaturas');

//     // Iterar sobre los id_asignaturas y crear un nuevo PlanCourse para cada uno
//     foreach ($id_asignaturas as $id_asignatura) {
//         PlanCourse::create([
//             'id_plan' => $id_plan,
//             'id_asignatura' => $id_asignatura,
//         ]);
//     }
//     return redirect()->route('plan-courses.index')
//     ->with('success', 'PlanCourse created successfully.');
//     }

//     public function store(Request $request)
// {
//     request()->validate(PlanCourse::$rules);

//     try {
//         // Realizar una solicitud POST a tu API para crear la entidad
//         $response = Http::post('http://127.0.0.1:8000/api/planCourses', $request->all());

//         // Verificar si la solicitud fue exitosa (código de respuesta 2xx)
//         if ($response->successful()) {
//             // La entidad fue creada exitosamente en tu API
//             // Redireccionar o devolver una respuesta adecuada
//             return redirect()->route('plan-courses.index')->with('success', 'PlanCourse created successfully.');
//         } else {
//             // La solicitud a tu API no fue exitosa
//             // Manejar el caso de error, mostrar un mensaje o realizar otra acción
//             return redirect()->back()->withInput()->withErrors(['message' => 'Error creating PlanCourse in the API.']);
//         }
//     } catch (RequestException $exception) {
//         // Manejar cualquier excepción que ocurra durante la solicitud HTTP
//         // Por ejemplo, si hay un problema de conexión con la API
//         // Manejar el caso de error, mostrar un mensaje o realizar otra acción
//         return redirect()->back()->withInput()->withErrors(['message' => 'Error connecting to the API.']);
//     }
// }
