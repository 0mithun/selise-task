<?php

namespace Database\Factories;

use App\Models\Department;
use App\Models\Employee;
use App\Models\EmployeeDetail;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employee>
 */
class EmployeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id'  =>    Str::uuid(),
            'department_id' => fn()=> Department::inRandomOrder()->first()->id,
            'name'          =>  $this->faker->name(),
            'email'         =>  $this->faker->safeEmail(),
        ];
    }

     /**
     * Configure the model factory.
     */
    public function configure(): static
    {
        return $this->afterCreating(function (Employee $employee) {
            $employee->detail()->create(EmployeeDetail::factory()->make()->toArray());
        });
    }
}
