<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class StudentCourse
 *
 * @property $id
 * @property $id_estudiante
 * @property $id_asignatura
 * @property $id_status
 * @property $created_at
 * @property $updated_at
 *
 * @property Course $course
 * @property Statusname $statusname
 * @property Student $student
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class StudentCourse extends Model
{
    static $rules = [
    ];

    protected $perPage = 20;
    protected $fillable = ['id_estudiante','id_asignatura','id_status'];

    public function course()
    {
        return $this->hasOne('App\Models\Course', 'id', 'id_asignatura');
    }
 
    public function statusname()
    {
        return $this->hasOne('App\Models\Statusname', 'id', 'id_status');
    }

    public function student()
    {
        return $this->hasOne('App\Models\Student', 'id', 'id_estudiante');
    }
}
