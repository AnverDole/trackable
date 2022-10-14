<?php

namespace App\Http\Controllers\SysAdmin;

use App\Http\Controllers\Controller;
use App\Models\CitiesOfSriLanka;
use App\Models\ProvincesOfSriLanka;
use App\Models\School;
use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class AdminManagement extends Controller
{
    public function index(Request $request)
    {

        $adminRoles = [
            User::$USER_ROLE_ACCOUNT_MANAGER => User::$role_ids[User::$USER_ROLE_ACCOUNT_MANAGER],
            User::$USER_ROLE_ADMIN => User::$role_ids[User::$USER_ROLE_ADMIN],
        ];

        $data = (object)$request->validate([
            "name" => "nullable|string|max:255",
            "email" => "nullable|string|max:255",
            "admin_role" => ["nullable", "string", "max:255", Rule::in(array_keys($adminRoles))]
        ]);

        $perpage = 20;

        $page = (int)$request->input("page", 1);
        if ($page <= 1) {
            $page = 1;
        }

        $cities = CitiesOfSriLanka::all();
        $provinces = ProvincesOfSriLanka::all();


        $admins = User::query()
            ->where(function (Builder $query) {
                $query->where(function (Builder $query) {
                    $query->filterRole(User::$USER_ROLE_ADMIN);
                })->orWhere(function (Builder $query) {
                    $query->filterRole(User::$USER_ROLE_ACCOUNT_MANAGER);
                });
            });

        if (isset($data->name)) {
            $admins->whereRaw("CONCAT_WS(' ', firstname, lastname) like ? ", ["%{$data->name}%"]);
        }

        if (isset($data->email)) {
            $admins->where("email", $data->email);
        }

        if (isset($data->admin_role)) {
            $admins->where("role", $data->admin_role);
        }

        $admins = $admins->orderBy("id", "desc")->paginate($perpage);

        return view('user-system-admin.admin-management.index', [
            "cities" => $cities,
            "adminRoles" => $adminRoles,
            "provinces" => $provinces,
            "admins" => $admins
        ]);
    }
    public function new(Request $request)
    {
        $cities = CitiesOfSriLanka::all();
        $provinces = ProvincesOfSriLanka::all();

        $roleIds = [];
        foreach (User::$role_ids as $id => $role) {
            if ($id == User::$USER_ROLE_PARENT) continue;
            if ($id == User::$USER_ROLE_SUPER_ADMIN) continue;

            $roleIds[$id] = $role;
        }

        return view('user-system-admin.admin-management.new', [
            "cities" => $cities,
            "provinces" => $provinces,
            "roleIds" => $roleIds,
        ]);
    }
    public function create(Request $request)
    {
        $data  = (object)$request->validate([
            "firstname" => "required|string|max:255",
            "lastname" => "required|string|max:255",
            "email" => "required|email|max:255|unique:schools,email",
            "telephone" => ["required", "regex:/(\+*94)([0-9]{9})/i"],
            "address_line_1" => "required|string|max:255",
            "address_line_2" => "nullable|string|max:255",
            "address_line_3" => "nullable|string|max:255",
            "city" => "required|integer|exists:cities_of_sri_lankas,id",
            "role_id" => ["required", "string", Rule::in([User::$USER_ROLE_ADMIN, User::$USER_ROLE_ACCOUNT_MANAGER])],
            "password" => "required|string|min:8",
        ], [], [
            "role_id" => "role"
        ]);

        try {
            DB::beginTransaction();

            $admin = User::create([
                "firstname" => $data->firstname,
                "lastname" => $data->lastname,
                "email" => $data->email,
                "telephone" => $data->telephone,
                "address_line_1" => $data->address_line_1,
                "address_line_2" => $data->address_line_2,
                "address_line_3" => $data->address_line_3,
                "city_id" => $data->city,
                "role" => $data->role_id,
                "password" => $data->password,
            ]);


            DB::commit();

            return redirect()->route('admin-management.view', ['admin' => $admin->id])
                ->with(["success-message" => "Successfully created the admin."]);
        } catch (Exception $e) {
            DB::rollBack();

            return redirect()->back()
                ->withInput($request->all())
                ->withErrors(["error-message" => "Failed create the admin, please try again."]);
        }
    }

    public function view(User $admin, Request $request)
    {
        $cities = CitiesOfSriLanka::all();
        $provinces = ProvincesOfSriLanka::all();

        return view('user-system-admin.admin-management.view', [
            "cities" => $cities,
            "provinces" => $provinces,
            'admin' => $admin
        ]);
    }

    public function edit(User $admin, Request $request)
    {
        $cities = CitiesOfSriLanka::all();
        $provinces = ProvincesOfSriLanka::all();

        $roleIds = [];
        foreach (User::$role_ids as $id => $role) {
            if ($id == User::$USER_ROLE_PARENT) continue;
            if ($id == User::$USER_ROLE_SUPER_ADMIN) continue;

            $roleIds[$id] = $role;
        }

        return view('user-system-admin.admin-management.edit', [
            "cities" => $cities,
            "provinces" => $provinces,
            'admin' => $admin,
            "roleIds" => $roleIds
        ]);
    }
    public function update(User $admin, Request $request)
    {

        $data  = (object)$request->validate([
            "firstname" => "required|string|max:255",
            "lastname" => "required|string|max:255",
            "email" => "required|email|max:255|unique:schools,email," . $admin->id,
            "telephone" => ["required", "regex:/(\+*94)([0-9]{9})/i"],
            "address_line_1" => "required|string|max:255",
            "address_line_2" => "nullable|string|max:255",
            "address_line_3" => "nullable|string|max:255",
            "city" => "required|integer|exists:cities_of_sri_lankas,id",
            "role_id" => ["required", "string", Rule::in([User::$USER_ROLE_ADMIN, User::$USER_ROLE_ACCOUNT_MANAGER])],
            "is_active" => "required|boolean"
        ], [], [
            "role_id" => "role"
        ]);

        try {
            DB::beginTransaction();


            $admin->firstname = $data->firstname;
            $admin->lastname = $data->lastname;
            $admin->email = $data->email;
            $admin->telephone = $data->telephone;
            $admin->address_line_1 = $data->address_line_1;
            $admin->address_line_2 = $data->address_line_2;
            $admin->address_line_3 = $data->address_line_3;
            $admin->city_id = $data->city;
            $admin->role = $data->role_id;
            $admin->is_active = $data->is_active;
            $admin->save();

            DB::commit();

            return redirect()->route('admin-management.view', ['admin' => $admin->id])
                ->with(["success-message" => "Successfully updated the admin."]);
        } catch (Exception $e) {
            DB::rollBack();

            return redirect()->back()
                ->withInput($request->all())
                ->withErrors(["error-message" => "Failed update the admin, please try again."]);
        }
    }

    public function addSchool(User $admin, Request $request)
    {
        $data = (object)$request->validate([
            "school_id" => "required|integer|exists:schools,id"
        ]);


        $school = School::findorfail($data->school_id);

        if ($admin->AssociatedSchools()->where("school_id", $school->id)->count() < 1) {

            $admin->AssociatedSchools()->attach($school->id);
            return redirect()->back()->with(["success-message" => "Successfully associated the school."]);
        } else {
            return redirect()->back()->withErrors(["error-message" => "Selected school is already associated with this admin account."]);
        }
    }
    public function removeSchool(User $admin, Request $request)
    {
        $data = (object)$request->validate([
            "school_id" => "required|integer|exists:schools,id"
        ]);


        $school = School::findorfail($data->school_id);

        if ($admin->AssociatedSchools()->where("school_id", $school->id)->count() > 0) {
            $admin->AssociatedSchools()->detach($school->id);
            return redirect()->back()->with(["success-message" => "Successfully removed the associated school."]);
        } else {
            return redirect()->back()->withErrors(["error-message" => "Selected school is not associated woth this admin account."]);
        }
    }

    public function getAccountManagers(Request $request)
    {
        $data = (object)$request->validate([
            "name" => "required_without_all:email|nullable|string|max:255",
            "email" => "required_without_all:name|nullable|email"
        ]);

        $perpage = 5;

        $page = (int)$request->input("page", 1);
        if ($page <= 1) {
            $page = 1;
        }

        $admins = User::query()->FilterRole(User::$USER_ROLE_ACCOUNT_MANAGER);

        if (isset($data->name) && strlen($data->name) > 0) {
            $admins->whereRaw("concat(firstname,' ',lastname) like ? ",  ["%{$data->name}%"]);
        }

        if (isset($data->email) && strlen($data->email) > 0) {
            $admins->where("email", $data->email);
        }


        $admins = $admins->orderBy("id", "desc")->limit($perpage)->get();

        $admins->map(function ($admin) {
            $admin->city = $admin->City;
            $admin->city->province = $admin->city->Province;
            return $admin;
        });

        return response()->json($admins);
    }
}
