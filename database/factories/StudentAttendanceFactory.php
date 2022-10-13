<?php

namespace Database\Factories;

use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;

class StudentAttendanceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $student = Student::all()->random();
        return [
            "student_id" => $student->id,
            "school_id" => $student->School->id,
            "direction" => random_int(0, 1)
        ];
    }
}
