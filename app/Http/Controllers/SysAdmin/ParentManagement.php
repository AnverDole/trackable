<?php

namespace App\Http\Controllers\SysAdmin;

use App\Http\Controllers\Controller;
use App\Models\CitiesOfSriLanka;
use App\Models\ProvincesOfSriLanka;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ParentManagement extends Controller
{
    public function index(Request $request)
    {

        $data = (object)$request->validate([
            "name" => "nullable|string|max:255",
            "email" => "nullable|string|max:255|email",
            "phone_number" => "nullable|string|max:255|regex:/(\+*94)([0-9]{9})/i"
        ]);

        $perpage = 20;

        $page = (int)$request->input("page", 1);
        if ($page <= 1) {
            $page = 1;
        }

        $parents = User::query()->FIlterRole(User::$USER_ROLE_PARENT);


        if (isset($data->name)) {
            $parents->whereRaw("CONCAT_WS(' ', firstname, lastname) like ? ", ["%{$data->name}%"]);
        }

        if (isset($data->email)) {
            $parents->where("email", $data->email);
        }

        if (isset($data->phone_number)) {
            $parents->where("telephone", $data->phone_number);
        }


        $parents = $parents->orderBy("id", "desc")->paginate($perpage);

        return view('user-system-admin.parent-management.index', [
            "parents" => $parents
        ]);
    }
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
                'is_active' => $data->city
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
    public function view(User $parent, Request $request)
    {
        return view("user-system-admin.parent-management.view", [
            "parent" => $parent
        ]);
    }

    public function edit(User $parent, Request $request)
    {
        $cities = CitiesOfSriLanka::all();
        $provinces = ProvincesOfSriLanka::all();

        return view("user-system-admin.parent-management.edit", [
            "provinces" => $provinces,
            "cities" => $cities,
            "parent" => $parent
        ]);
    }
    public function update(User $parent, Request $request)
    {
        $data  = (object)$request->validate([
            "email" => "required|string|max:255|email|unique:users,email," . $parent->id,
            "firstname" => "required|string|max:255",
            "lastname" => "required|string|max:255",
            "address_line_1" => "required|string|max:255",
            "address_line_2" => "nullable|string|max:255",
            "address_line_3" => "nullable|string|max:255",
            "city" => "required|integer|exists:cities_of_sri_lankas,id",

            "phone_number" => ["required", "regex:/(\+*94)([0-9]{9})/i"],
            "is_active" => "required|in:0,1"
        ]);

        try {
            DB::beginTransaction();


            $parent->firstname = $data->firstname;
            $parent->lastname = $data->lastname;
            $parent->email = $data->email;
            $parent->telephone = $data->phone_number;
            $parent->address_line_1 = $data->address_line_1;
            $parent->address_line_2 = $data->address_line_2;
            $parent->address_line_3 = $data->address_line_3;
            $parent->city_id = $data->city;
            $parent->is_active = $data->is_active;

            $parent->save();


            DB::commit();

            return redirect()->route('parent-management.view', ['parent' => $parent->id])
                ->with(["success-message" => "Successfully created the parent account."]);
        } catch (Exception $e) {
            return redirect()->back()
                ->withInput($request->all())
                ->withErrors(["error-message" => "Failed created the parent account."]);
        }

    }

    public function getParents(Request $request)
    {

        $data = (object)$request->validate([
            "email" => "required_without:phone_number|nullable|email",
            "phone_number" => "required_without:email|nullable|string",
        ]);

        $parents = User::FilterRole(User::$USER_ROLE_PARENT);

        if (isset($data->email)) {
            $parents->where("email", $data->email);
        }
        if (isset($data->phone_number)) {
            $parents->where("telephone", $data->phone_number);
        }

        $parents = $parents->orderBy("id", "desc")->limit(10)->get();

        $parents->map(function ($parent) {
            $parent->city = $parent->City;
            $parent->city->province = $parent->city->Province;
            return $parent;
        });

        return response()->json($parents);
    }
}
