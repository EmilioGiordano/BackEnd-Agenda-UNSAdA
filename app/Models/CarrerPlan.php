<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class CarrerPlan extends Model
{
    
    static $rules = [
		'name' => 'required|max:120',
		'proposal_code' => 'required|max:10',
    ];

    protected $perPage = 20;


    protected $fillable = ['name','proposal_code'];


    public function planCourses()
    {
        return $this->hasMany('App\Models\PlanCourse', 'id_plan', 'id');
    }
    
    public function students()
    {
        return $this->hasMany('App\Models\Student', 'id_plan_carrera', 'id');
    }
    

}
