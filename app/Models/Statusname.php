<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
/**
 * Class Statusname
 * @property $id
 * @property $name
 * @property StudentCourse[] $studentCourses
 * @package App
 */
class Statusname extends Model
{   
    protected $table = 'statusname';
    static $rules = [
    ];
    protected $perPage = 20;
    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['name'];
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function studentCourses()
    {
        return $this->hasMany('App\Models\StudentCourse', 'id_status', 'id');
    }
}
