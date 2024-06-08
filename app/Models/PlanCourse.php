<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class PlanCourse

 * @property $id
 * @property $id_plan
 * @property $id_asignatura
 * @property $created_at
 * @property $updated_at
 */
class PlanCourse extends Model
{
    
    static $rules = [
    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['id_plan','id_asignatura'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function carrerPlan()
    {
        return $this->hasOne('App\Models\CarrerPlan', 'id', 'id_plan');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function course()
    {
        return $this->hasOne('App\Models\Course', 'id', 'id_asignatura');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function prerequisites()
    {
        return $this->hasMany('App\Models\Prerequisite', 'id_plan_asignatura', 'id');
    }
    

}
