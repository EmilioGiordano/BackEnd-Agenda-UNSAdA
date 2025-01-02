<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Status
 *
 * @property $id
 * @property $name
 *
 * @property StudentCourse[] $studentCourses
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Status extends Model
{
    
    protected $fillable = ['name'];
    static $rules = [
        'name' => 'required',   
    ];
    protected $perPage = 20;
    
    
    public function studentCourses()
    {
        return $this->hasMany(\App\Models\StudentCourse::class, 'id', 'id_status');
    }
    

}
