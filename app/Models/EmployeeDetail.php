<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeDetail extends Model
{
    use HasFactory;

    protected $table = 'employee_detail';

    protected $fillable =[
        'employee_id',
        'designation',
        'salary',
        'address',
        'joined_date',
    ];


}
