<?php


namespace App\Builders;

use App\Models\EmployeeDetail;
use Illuminate\Database\Eloquent\Builder;

class EmployeeBuilder extends Builder
{

    public function filterByDepartment(): self
    {
        if(request('department')) {
            $departmentArray = explode(',', request('department'));
            return  $this->whereIn('employee.department_id', $departmentArray);
        }

        return $this;
    }


    public function overviewSearch(): self
    {
        return $this->where(function ($q) {
            $search = request('search');

            $q->orWhere('employee.name', 'LIKE', "%$search%");
        });
    }


    /**
     * Order By columns
     *
     * @return self
     */
    public function orderByColumn(): self
    {
        $orderBy = request('order_by');
        $direction = request('direction', 'ASC');

        if($orderBy == 'joined_date') {
            $this->orderBy(
                EmployeeDetail::select('joined_date')->whereColumn('employee_detail.employee_id', 'employee.id'),
                $direction
            );
        }

        return $this->orderBy('id', 'DESC');
    }
}
