<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class StudentCourse
 *
 * @property $id
 * @property $id_estudiante
 * @property $id_asignatura
 * @property $created_at
 * @property $updated_at
 */
class StudentCourse extends Model
{
    
    static $rules = [
    ];

    protected $perPage = 20;
    protected $fillable = ['id_estudiante','id_asignatura'];

    public function course()
    {
        return $this->hasOne('App\Models\Course', 'id', 'id_asignatura');
    }
    
    public function student()
    {
        return $this->hasOne('App\Models\Student', 'id', 'id_estudiante');
    }
    

}
