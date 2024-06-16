<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\StudentController;
use App\Http\Controllers\Api\CourseController;
use App\Http\Controllers\Api\CarrerPlanController;
use App\Http\Controllers\Api\PlanCourseController;
use App\Http\Controllers\Api\PrerequisiteController;
use App\Http\Controllers\Api\StudentCourseController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\AuthController;

// -------- USER APIs -------- //

Route::post('/register', [UserController::class, 'store']);
Route::post('/login', [UserController::class, 'login']);


// -------- STUDENTS APIs -------- //

Route::get('/students', [StudentController::class, 'index']);
Route::get('/students/{id}', [StudentController::class, 'show']);
Route::post('/students', [StudentController::class, 'store']);
Route::put('/students/{id}', [StudentController::class, 'update']);
Route::patch('/students/{id}', [StudentController::class, 'updatePartial']);
Route::delete('/students/{id}', [StudentController::class, 'destroy']);
// Route::get('/students/{id}/plan', [StudentController::class, 'showWithPlan']); NO SE USA MÁS
Route::get('/students/{id}/courses', [StudentController::class, 'showCourses']);
// Cargar ID_STATUS en student_courses 
Route::patch('/students/{id}/courses/status', [StudentController::class, 'updateCoursesStatuses']);

Route::get('/students/{id}/courses/status', [StudentController::class, 'getStudentCoursesStatuses']);


// -------- COURSES APIs -------- //

Route::get('/courses', [CourseController::class, 'index']);
Route::get('/courses/{id}', [CourseController::class, 'show']);
Route::post('/courses', [CourseController::class, 'store']);
Route::put('/courses/{id}', [CourseController::class, 'update']);
Route::patch('/courses/{id}', [CourseController::class, 'updatePartial']);
Route::delete('/courses/{id}', [CourseController::class, 'destroy']);

// -------- CARRER PLANS APIs -------- //

Route::get('/carrerPlans', [CarrerPlanController::class, 'index']);
Route::get('/carrerPlans/{id}', [CarrerPlanController::class, 'show']);
Route::post('/carrerPlans', [CarrerPlanController::class, 'store']);
Route::put('/carrerPlans/{id}', [CarrerPlanController::class, 'update']);
Route::patch('/carrerPlans/{id}', [CarrerPlanController::class, 'updatePartial']);
Route::delete('/carrerPlans/{id}', [CarrerPlanController::class, 'destroy']);

// -------- PLAN COURSE RELATION APIs -------- //

Route::get('/planCourses', [PlanCourseController::class, 'index']);
Route::get('/planCourses/{id}', [PlanCourseController::class, 'show']);
Route::post('/planCourses', [PlanCourseController::class, 'store']);
Route::put('/planCourses/{id}', [PlanCourseController::class, 'update']);
Route::patch('/planCourses/{id}', [PlanCourseController::class, 'updatePartial']);
Route::delete('/planCourses/{id}', [PlanCourseController::class, 'destroy']);        
// -------- Todas las asignaturas de un Plan -------- //
Route::get('/carrerPlans/{id}/courses', [CarrerPlanController::class, 'getCourses']);


// -------- PLAN COURSE RELATION APIs -------- //

Route::get('/prerequisites', [PrerequisiteController::class, 'index']);
Route::get('/prerequisites/{id}', [PrerequisiteController::class, 'show']);
Route::post('/prerequisites', [PrerequisiteController::class, 'store']);
Route::put('/prerequisites/{id}', [PrerequisiteController::class, 'update']);
Route::patch('/prerequisites/{id}', [PrerequisiteController::class, 'updatePartial']);
Route::delete('/prerequisites/{id}', [PrerequisiteController::class, 'destroy']);



// QUERY
Route::get('/executequery', [StudentCourseController::class, 'executeQuery']);

