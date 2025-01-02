<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Course
 *
 * @property $id
 * @property $course_code
 * @property $name
 * @property $year
 * @property $semester
 * @property $departament
 * @property $created_at
 * @property $updated_at
 *
 * @property PlanCourse[] $planCourses
 * @property Prerequisite[] $prerequisites
 * @property StudentCourse[] $studentCourses
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Course extends Model
{
    protected $perPage = 20;
    protected $fillable = [
        'course_code',
        'name',
        'year',
        'semester',
        'departament'
    ];
    
    static $rules = [
		'course_code' => 'required',
		'name' => 'required|between: 1,5',
		'year' => 'required|in: 1,2',
		'semester' => 'required',
		'id_department' => 'required',
    ];

    public function department()
    {
        return $this->belongsTo('App\Models\Department', 'department', 'id');
    }

    public function planCourses()
    {
        return $this->hasMany('App\Models\PlanCourse', 'id_asignatura', 'id');
    }
    
    public function prerequisites()
    {
        return $this->hasMany('App\Models\Prerequisite', 'id_asigCorrelativa', 'id');
    }
    
    public function studentCourses()
    {
        return $this->hasMany('App\Models\StudentCourse', 'id_asignatura', 'id');
    }
}
