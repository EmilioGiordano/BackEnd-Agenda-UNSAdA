<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
/**
 * Class Student
 *
 * @property $id
 * @property $id_user
 * @property $id_plan_carrera
 * @property $name
 * @property $surname
 * @property $dni
 * @property $created_at
 * @property $updated_at
 *
 * @property CarrerPlan $carrerPlan
 * @property StudentCourse[] $studentCourses
 * @property User $user
 */
class Student extends Model
{ 
    static $rules = [
		'name' => 'required',
		'surname' => 'required',
		'dni' => 'required',
        'id_plan_carrera' => 'not required',
        'id_plan' => 'not required'
    ];

    protected $perPage = 20;
    protected $fillable = [
        'id_user',
        'id_plan_carrera',
        'name',
        'surname',
        'dni'
    ];

    public function carrerPlan()
    {
        return $this->hasOne('App\Models\CarrerPlan', 'id', 'id_plan_carrera');
    }
    
    public function studentCourses()
    {
        return $this->hasMany('App\Models\StudentCourse', 'id_estudiante', 'id');
    }
 
    public function user()
    {
        return $this->hasOne('App\Models\User', 'id', 'id_user');
    }
}
