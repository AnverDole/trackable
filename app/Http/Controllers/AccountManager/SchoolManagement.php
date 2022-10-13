<?php

namespace App\Http\Controllers\AccountManager;

use App\Http\Controllers\Controller;
use App\Models\CitiesOfSriLanka;
use App\Models\ProvincesOfSriLanka;
use App\Models\School;
use App\Models\Student;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class SchoolManagement extends Controller
{
    public function index(Request $request)
    {

        $data = (object)$request->validate([
            "name" => "nullable|string|max:255",
            "province" => "nullable|string|max:255|exists:provinces_of_sri_lankas,id",
            "city" => "nullable|string|max:255|exists:cities_of_sri_lankas,id"
        ]);

        $perpage = 20;

        $page = (int)$request->input("page", 1);
        if ($page <= 1) {
            $page = 1;
        }


        $cities = CitiesOfSriLanka::all();
        $provinces = ProvincesOfSriLanka::all();

        $schools = Auth::user()->AssociatedSchools()->orderBy("id", "desc");

        if (isset($data->name)) {
            $schools->where("name", "like", "%{$data->name}%");
        }

        if (isset($data->city)) {
            $schools->where("city_id", $data->city);
        }
        if (isset($data->province)) {
            $schools->orWhereHas("City.Province", function (Builder $query) use ($data) {
                $query->where("id", $data->province);
            });
        }


        $schools = $schools->get();

        return view('user-account-manager.school-management.index', [
            "cities" => $cities,
            "provinces" => $provinces,
            "schools" => $schools
        ]);
    }
    public function new(Request $request)
    {
        $cities = CitiesOfSriLanka::all();
        $provinces = ProvincesOfSriLanka::all();

        return view('user-account-manager.school-management.new', [
            "cities" => $cities,
            "provinces" => $provinces,
        ]);
    }
    public function create(Request $request)
    {
        $data  = (object)$request->validate([
            "name" => "required|string|max:255",
            "email" => "required|email|max:255|unique:schools,email",
            "telephone" => ["required", "regex:/(0|\+*94)([0-9]{9})/i"],
            "address_line_1" => "required|string|max:255",
            "address_line_2" => "nullable|string|max:255",
            "address_line_3" => "nullable|string|max:255",
            "city" => "required|integer|exists:cities_of_sri_lankas,id",
            "mac_addresses" => "required|array|min:1",
            "mac_addresses.*" => "required|string|regex:/^([a-fA-F0-9]{2}:){5}[a-fA-F0-9]{2}$/",
        ], [], [
            "mac_addresses.*" => "mac address"
        ]);

        try {
            DB::beginTransaction();

            $school = School::create([
                "name" => $data->name,
                "email" => $data->email,
                "telephone" => $data->telephone,
                "address_line_1" => $data->address_line_1,
                "address_line_2" => $data->address_line_2,
                "address_line_3" => $data->address_line_3,
                "city_id" => $data->city,
            ]);

            $school->RFIDDetectors()->delete();
            foreach ($data->mac_addresses as $mac) {
                $school->RFIDDetectors()->create([
                    "mac_address" => $mac
                ]);
            }

            DB::commit();

            return redirect()->back()
                ->with(["success-message" => "Successfully inserted the new school."]);
        } catch (Exception $e) {
            DB::rollBack();

            return redirect()->back()
                ->withInput($request->all())
                ->withErrors(["error-message" => "Failed inserted the new school, please try again."]);
        }
    }

    public function view(School $school, Request $request)
    {
        $cities = CitiesOfSriLanka::all();
        $provinces = ProvincesOfSriLanka::all();

        return view('user-account-manager.school-management.view', [
            'school' => $school,
            'cities' => $cities,
            'provinces' => $provinces
        ]);
    }

    public function edit(School $school, Request $request)
    {
        $cities = CitiesOfSriLanka::all();
        $provinces = ProvincesOfSriLanka::all();

        return view('user-account-manager.school-management.edit', [
            "cities" => $cities,
            "provinces" => $provinces,
            'school' => $school
        ]);
    }
    public function update(School $school, Request $request)
    {
        $data  = (object)$request->validate([
            "name" => "required|string|max:255",
            "email" => "required|email|max:255|unique:schools,email," . $school->id,
            "telephone" => ["required", "regex:/(0|\+*94)([0-9]{9})/i"],
            "address_line_1" => "required|string|max:255",
            "address_line_2" => "nullable|string|max:255",
            "address_line_3" => "nullable|string|max:255",
            "city" => "required|integer|exists:cities_of_sri_lankas,id",
            "mac_addresses.*" => "required|string|regex:/^([a-fA-F0-9]{2}:){5}[a-fA-F0-9]{2}$/",
        ], [], [
            "mac_addresses.*" => "mac address"
        ]);

        try {
            DB::beginTransaction();


            $school->name = $data->name;
            $school->email = $data->email;
            $school->telephone = $data->telephone;
            $school->address_line_1 = $data->address_line_1;
            $school->address_line_2 = $data->address_line_2;
            $school->address_line_3 = $data->address_line_3;
            $school->city_id = $data->city;
            $school->save();


            $school->RFIDDetectors()->delete();
            foreach ($data->mac_addresses as $mac) {
                $school->RFIDDetectors()->create([
                    "mac_address" => $mac
                ]);
            }

            DB::commit();

            return redirect()->route('school-management.view', ['school' => $school->id])
                ->with(["success-message" => "Successfully updated the school."]);
        } catch (Exception $e) {
            DB::rollBack();

            return redirect()->back()
                ->withInput($request->all())
                ->withErrors(["error-message" => "Failed update the school, please try again."]);
        }
    }


    public function students(School $school, Request $request)
    {

        $data = (object)$request->validate([
            "name" => "nullable|string|max:255",
            "rfid_tag" => "nullable|string|max:255",
            "local_index" => "nullable|string|max:255"
        ]);

        $perpage = 20;

        $page = (int)$request->input("page", 1);
        if ($page <= 1) {
            $page = 1;
        }

        $cities = CitiesOfSriLanka::all();


        $students = $school->Students();


        if (isset($data->name)) {
            $students->whereRaw("CONCAT_WS(' ', firstname, lastname) like ? ", ["%{$data->name}%"]);
        }

        if (isset($data->local_index)) {
            $students->where("local_index", $data->local_index);
        }

        if (isset($data->rfid_tag)) {
            $students->where("tag_id", $data->rfid_tag);
        }


        $students = $students->orderBy("id", "desc")->paginate($perpage);

        return view('user-account-manager.school-management.students', [
            "cities" => $cities,
            "students" => $students,
            "school" => $school,
        ]);
    }

    public function attendances(School $school, Request $request)
    {
        $data = (object)$request->validate([
            "name" => "nullable|string|max:255",
            "rfid_tag" => "nullable|string|max:255",
            "local_index" => "nullable|string|max:255",
            "attendance_date" => "nullable|date"
        ]);

        $perpage = 20;

        $page = (int)$request->input("page", 1);
        if ($page <= 1) {
            $page = 1;
        }


        $attendances = $school->attendances();

        if (isset($data->name) && strlen($data->name) > 0) {
            $attendances->whereHas("Student", function (Builder $query) use ($data) {
                $query->whereRaw("CONCAT_WS(' ', firstname, lastname) like ? ", ["%{$data->name}%"]);
            });
        }

        if (isset($data->local_index) && strlen($data->local_index) > 0) {
            $attendances->whereHas("Student", function (Builder $query) use ($data) {
                $query->where("local_index", $data->local_index);
            });
        }

        if (isset($data->rfid_tag) && strlen($data->rfid_tag) > 0) {
            $attendances->whereHas("Student", function (Builder $query) use ($data) {
                $query->where("tag_id", $data->rfid_tag);
            });
        }

        if (isset($data->attendance_date) && strlen($data->attendance_date) > 0) {
            $attendances->whereDate("created_at", "=", $data->attendance_date);
        }

        $attendances = $attendances->orderBy("created_at", "desc")->paginate($perpage);

        return view('user-account-manager.school-management.attendances', [
            "school" => $school,
            "attendances" => $attendances
        ]);
    }
}
