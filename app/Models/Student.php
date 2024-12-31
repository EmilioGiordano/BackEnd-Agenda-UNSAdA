<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{ 
    static $rules = [
        'dni' => 'required|size:8',
		'fullname' => 'required',
        'id_user' => 'required',
        'id_carrer_plan' => 'not required',   
    ];

    protected $perPage = 20;

    // Se utiliza para definir los campos de un modelo que pueden ser asignados masivamente
    protected $fillable = [
        'fullname',
        'dni'
    ];

    // Propietario: carrer_plans
    public function carrerPlan()
    {
        return $this->belongsTo('App\Models\CarrerPlan', 'id', 'id_carrer_plan');
    }

 

    // Propietario: user

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'id', 'id_user');
    }

        // public function studentCourses()
    // {
    //     return $this->hasMany('App\Models\StudentCourse', 'id_student', 'id');
    // }
}
