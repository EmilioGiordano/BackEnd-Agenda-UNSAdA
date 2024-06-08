<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSettings extends Model
{
    use HasFactory;
    public $fillable = ['id_condicion_fiscal', 'password_actual', 'password', 'confirm_password'];


    public function fiscalCondition()
    {
        return $this->hasOne('App\Models\FiscalCondition', 'id', 'id_condicion_fiscal');
    }
}
