<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $perPage = 20;

    protected $fillable = [
        'dni', 
        'full_name', 
        'id_user', 
        'id_carrer_plan'
    ];
    
    static $rules = [
        'dni' => 'required|min:8|max:8',
        'full_name' => 'required',
        'id_user' => 'required',
        'id_carrer_plan' => 'not required'
    ];

    public function carrerPlan()
    {
        return $this->belongsTo(CarrerPlan::class, 'id_carrer_plan', 'id');
    }
    
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }
    
    public function studentCourses()
    {
        return $this->hasMany(StudentCourse::class, 'id_student', 'id');
    }
}
