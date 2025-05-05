<?php

namespace App\Http\Resources\Employee;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return  [
            'id'        =>  $this->id,
            'department_id' =>  $this->department_id,
            'name'      =>  $this->name,
            'email'     =>  $this->email,
            'detail'    =>  $this->detail,
            'department'    =>  $this->department,
        ];
    }
}
