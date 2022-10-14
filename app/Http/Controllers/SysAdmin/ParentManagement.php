<?php

namespace App\Http\Controllers\SysAdmin;

use App\Http\Controllers\Controller;
use App\Models\CitiesOfSriLanka;
use App\Models\ProvincesOfSriLanka;
use App\Models\Student;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ParentManagement extends Controller
{
    public function new(Request $request)
    {
        $cities = CitiesOfSriLanka::all();
        $provinces = ProvincesOfSriLanka::all();

        return view('user-system-admin.parent-management.new', [
            "cities" => $cities,
            "provinces" => $provinces,
        ]);
    }
    public function create(Request $request)
    {
        $data  = (object)$request->validate([
            "email" => "required|string|max:255|email|unique:users,email",
            "firstname" => "required|string|max:255",
            "lastname" => "required|string|max:255",
            "address_line_1" => "required|string|max:255",
            "address_line_2" => "nullable|string|max:255",
            "address_line_3" => "nullable|string|max:255",
            "city" => "required|integer|exists:cities_of_sri_lankas,id",

            "phone_number" => ["required", "regex:/(\+*94)([0-9]{9})/i"]


        ]);

        try {
            DB::beginTransaction();

            User::create([
                'firstname' => $data->firstname,
                'lastname' => $data->lastname,
                'email' => $data->email,
                'role' => User::$USER_ROLE_PARENT,
                'password' => Hash::make("1234567890"),
                'telephone' => $data->phone_number,
                'address_line_1' => $data->address_line_1,
                'address_line_2' => $data->address_line_2,
                'address_line_3' => $data->address_line_3,
                'city_id' => $data->city
            ]);

            DB::commit();

            return redirect()->route('student-management.parents.new')
                ->with(["success-message" => "Successfully created the parent account."]);
        } catch (Exception $e) {
            return redirect()->back()
                ->withInput($request->all())
                ->withErrors(["error-message" => "Failed created the parent account."]);
        }
    }
}
