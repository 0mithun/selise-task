<?php

namespace Database\Factories;

use App\Models\Employee;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\EmployeeDetail>
 */
class EmployeeDetailFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'employee_id'           =>  fn()=> Employee::inRandomOrder()->first()->id,
            'designation'           =>  $this->faker->colorName(),
            'salary'            =>  mt_rand(1000, 1000000),
            'address'           =>  $this->faker->address(),
            'joined_date'           =>  $this->faker->date(),
        ];
    }
}
