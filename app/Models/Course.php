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
    
    static $rules = [
		'course_code' => 'required',
		'name' => 'required',
		'year' => 'required',
		'semester' => 'required',
		'departament' => 'required',
    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['course_code','name','year','semester','departament'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function planCourses()
    {
        return $this->hasMany('App\Models\PlanCourse', 'id_asignatura', 'id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function prerequisites()
    {
        return $this->hasMany('App\Models\Prerequisite', 'id_asigCorrelativa', 'id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function studentCourses()
    {
        return $this->hasMany('App\Models\StudentCourse', 'id_asignatura', 'id');
    }
    

}
