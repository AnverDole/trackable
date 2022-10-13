<?php

namespace Database\Factories;

use App\Models\CitiesOfSriLanka;
use App\Models\School;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class StudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'firstname' => $this->faker->firstName,
            'lastname' => $this->faker->lastName,
            'address_line_1' => $this->faker->streetAddress,
            'address_line_2' => $this->faker->streetAddress,
            'address_line_3' => $this->faker->streetAddress,
            'city_id' => CitiesOfSriLanka::all()->random()->id,
            'tag_id' =>  $this->faker->numberBetween(100000000, 999999999),
            'school_id' => School::all()->random()->id,
            'parent_id' => User::FilterRole(User::$USER_ROLE_PARENT)->get()->random()->id,
            'local_index' => $this->faker->numberBetween(100000000, 999999999),
        ];
    }
}
