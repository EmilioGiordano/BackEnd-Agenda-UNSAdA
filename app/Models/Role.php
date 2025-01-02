<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = ['name'];
    
    static $rules = [
        'name' => 'required|max:30',
    ];

    
    public function users()
    {
        return $this->hasMany(\App\Models\User::class, 'id', 'id_role');
    }
    

}
