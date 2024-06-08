<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property $id
 * @property $id_plan_asignatura
 * @property $id_asignaturaCorrelativa
 * @property $created_at
 * @property $updated_at
 */
class Prerequisite extends Model
{
    
    static $rules = [
    ];

    protected $perPage = 20;


    protected $fillable = ['id_asignaturaCorrelativa','id_plan_asignatura'];

    public function planCourse()
    {
        return $this->hasOne('App\Models\PlanCourse', 'id', 'id_plan_asignatura');
    }
    
    public function course()
    {
        return $this->hasOne('App\Models\Course', 'id', 'id_asignaturaCorrelativa');
    }

  
    

}
