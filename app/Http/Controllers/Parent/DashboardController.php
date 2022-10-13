<?php

namespace App\Http\Controllers\Parent;

use App\Http\Controllers\Controller;
use App\Models\School;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $data = (object)[];

        $data->childs = Auth::user()->Childs()->orderby('created_at', "desc")->get();

        return view("user-parent.dashboard", ["data" => $data]);
    }
}
