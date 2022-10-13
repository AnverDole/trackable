<?php

namespace Database\Factories;

use App\Models\CitiesOfSriLanka;
use App\Models\ProvincesOfSriLanka;
use Illuminate\Database\Eloquent\Factories\Factory;

class SchoolFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "name" => $this->faker->name()  . " " . "School",
            "email" => $this->faker->safeEmail(),
            "telephone" => "0" . $this->faker->randomNumber(9),
            "address_line_1" => $this->faker->streetAddress(),
            "address_line_2" => $this->faker->streetAddress(),
            "address_line_3" => null,
            "city_id" => CitiesOfSriLanka::all()->random()->id
        ];
    }
}
