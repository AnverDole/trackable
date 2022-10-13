<?php

namespace Database\Seeders;

use App\Models\School;
use App\Models\Student;
use App\Models\StudentAttendance;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::factory(10)->SuperAdmin()->create();
        User::factory(10)->Admin()->create();
        User::factory(10)->AccountManager()->create();
        User::factory(10)->Parent()->create();
        School::factory(10)->create();
        Student::factory(100)->create();
        StudentAttendance::factory(100)->create();
    }
}
