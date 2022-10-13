<?php

namespace App\Http\Controllers\SysAdmin;

use App\Http\Controllers\Controller;
use App\Models\School;
use App\Models\Student;
use App\Models\StudentAttendance;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $data = (object)[];

        $data->TotalAttendance = StudentAttendance::query()->Today()->count();
        $data->lateStudents = StudentAttendance::query()->Today()->count();

        $data->schools = School::query()->count();
        $data->students = Student::query()->Active()->count();

        return view("user-system-admin.dashboard", ["data" => $data]);
    }
}
