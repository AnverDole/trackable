<?php

namespace Database\Factories;

use App\Models\CitiesOfSriLanka;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'firstname' => $this->faker->firstName(),
            'lastname' => $this->faker->lastName(),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => Hash::make("1234567890"),
            "telephone" => "0" . $this->faker->randomNumber(9),
            "address_line_1" => $this->faker->streetAddress(),
            "address_line_2" => $this->faker->streetAddress(),
            "address_line_3" => null,
            "city_id" => CitiesOfSriLanka::all()->random()->id
        ];
    }

    /**
     * Indicate that the user should be a super admin.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function SuperAdmin()
    {
        return $this->state(function (array $attributes) {
            return [
                'role' => User::$USER_ROLE_SUPER_ADMIN
            ];
        });
    }
    /**
     * Indicate that the user should be a admin.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function Admin()
    {
        return $this->state(function (array $attributes) {
            return [
                'role' => User::$USER_ROLE_ADMIN
            ];
        });
    }
    /**
     * Indicate that the user should be a admin.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function AccountManager()
    {
        return $this->state(function (array $attributes) {
            return [
                'role' => User::$USER_ROLE_ACCOUNT_MANAGER
            ];
        });
    }
    /**
     * Indicate that the user should be a admin.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function Parent()
    {
        return $this->state(function (array $attributes) {
            return [
                'role' => User::$USER_ROLE_PARENT
            ];
        });
    }
}
