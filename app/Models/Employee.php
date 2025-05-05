<?php

namespace App\Models;

use App\Builders\EmployeeBuilder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Employee extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'employee';
    protected $keyType = 'string';
    public $incrementing = false;



    protected $fillable = [
        'id',
        'department_id',
        'name',
        'email',
    ];

    public function detail() {
        return $this->hasOne(EmployeeDetail::class);
    }

    public function department() {
        return $this->belongsTo(Department::class);
    }

    public function newEloquentBuilder($query)
    {
        return new EmployeeBuilder($query);
    }
}
