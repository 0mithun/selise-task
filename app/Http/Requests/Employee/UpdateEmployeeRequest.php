<?php

namespace App\Http\Requests\Employee;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEmployeeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */

     /**
    * @unauthenticated
    * @bodyParam email string required
    * @bodyParam department_id int required
    * @bodyParam designation string required
    * @bodyParam salary number required
    * @bodyParam address string required
    * @bodyParam joined_date string required
    */
    public function rules(): array
    {
        return [
            'email'         =>  ['required'],
            'department_id' =>   ['required', 'exists:department,id'],
            'designation'   =>  ['required'],
            'salary'        =>  ['required', 'numeric'],
            'address'       =>  ['required'],
            'joined_date'   =>  ['required', 'date'],
        ];
    }
}
