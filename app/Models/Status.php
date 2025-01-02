<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    
    protected $fillable = ['name'];
    static $rules = [
        'name' => 'required',   
    ];

    
    
    public function studentCourses()
    {
        return $this->hasMany(\App\Models\StudentCourse::class, 'id', 'id_status');
    }
    

}
