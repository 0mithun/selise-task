<?php

namespace App\Http\Controllers\Api\Department;

use App\Http\Controllers\Controller;
use App\Http\Resources\Department\DepartmentResource;
use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $departments = Department::query()->get();

        return DepartmentResource::collection($departments);
    }
}
