<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $perPage = 20;
    protected $fillable = ['name'];


    public function courses()
    {
        return $this->hasMany(\App\Models\Course::class, 'id', 'id_department');
    }

}
