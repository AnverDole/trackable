<?php

namespace App\Http\Controllers\AccountManager;

use App\Http\Controllers\Controller;
use App\Models\School;
use App\Models\Student;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $data = (object)[];

        $data->schools = School::query()->count();
        $data->students = Student::query()->Active()->count();

        return view("user-account-manager.dashboard", ["data" => $data]);
    }
}
