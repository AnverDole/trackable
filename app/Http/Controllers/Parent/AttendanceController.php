<?php

namespace App\Http\Controllers\Parent;

use App\Http\Controllers\Controller;
use App\Models\School;
use App\Models\Student;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    public function index(Student $student, Request $request)
    {
        $data = (object)[];

        $data = (object)$request->validate([
            "attendance_date" => "nullable|date"
        ]);

        $perpage = 20;

        $page = (int)$request->input("page", 1);
        if ($page <= 1) {
            $page = 1;
        }


        $attendances = $student->attendances();


        if (isset($data->attendance_date) && strlen($data->attendance_date) > 0) {
            $attendances->whereDate("created_at", "=", $data->attendance_date);
        }

        $data->attendances = $attendances->orderBy("created_at", "desc")->paginate($perpage);
        $data->student = $student;

        return view("user-parent.attendances", [
            "data" => $data
        ]);
    }
}
