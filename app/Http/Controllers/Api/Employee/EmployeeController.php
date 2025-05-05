<?php

namespace App\Http\Controllers\Api\Employee;

use App\Models\Employee;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Resources\Employee\EmployeeResource;
use App\Http\Requests\Employee\CreateEmployeeRequest;
use App\Http\Requests\Employee\UpdateEmployeeRequest;
use App\Models\Department;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $employees = Employee::query()
            ->with('detail', 'department')
            ->filterByDepartment()
            ->overviewSearch()
            ->orderByColumn()
            ->paginate(request('per_page', 10));

        return EmployeeResource::collection($employees);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateEmployeeRequest $request)
    {
        try {
            DB::beginTransaction();
            $employee = Employee::create($request->only('name', 'email', 'department_id') + [
                'id'    => Str::uuid(),
            ]);

            $employee->detail()->create($request->only([
                'designation','salary','address','joined_date',
            ]));

            DB::commit();
            return response(new EmployeeResource($employee), Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Employee $employee)
    {
        return new EmployeeResource($employee);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEmployeeRequest $request, Employee $employee)
    {
        try {
            DB::beginTransaction();

            $employee->update($request->only('name', 'email'));

            $employee->detail()->update($request->only([
                'designation','salary','address','joined_date',
            ]));

            DB::commit();

            return response(new EmployeeResource($employee), Response::HTTP_ACCEPTED);
        }catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee)
    {
        $employee->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }


    public function getFilterData(Request $request)
    {
        $request->validate([
            'column'   =>  ['required']
        ]);

        if ($request->column == 'department') {
            return Department::query()
                ->select('name', 'id')
                ->orderBy('name', 'ASC')
                ->get();
        }
    }
}
