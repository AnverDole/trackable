<?php

namespace App\Http\Controllers\AccountManager;

use App\Http\Controllers\Controller;
use App\Models\CitiesOfSriLanka;
use App\Models\ProvincesOfSriLanka;
use App\Models\School;
use App\Models\Student;
use App\Models\StudentAttendance;
use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class StudentManagement extends Controller
{
    public function index(Request $request)
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


        $students = Student::query();



        $students->whereHas("School.AssociatedAccountManagers", function (Builder $query) {
            $query->where("user_id", Auth::user()->id);
        });

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

        return view('user-account-manager.student-management.index', [
            "cities" => $cities,
            "students" => $students
        ]);
    }
    public function new(Request $request)
    {
        $cities = CitiesOfSriLanka::all();
        $provinces = ProvincesOfSriLanka::all();

        $schools = Auth::user()->AssociatedSchools();

        $schools = $schools->orderBy("id", "desc")->get();

        $schools->map(function ($school) {
            $school->city = $school->City;
            $school->city->province = $school->city->Province;
            return $school;
        });


        return view('user-account-manager.student-management.new', [
            "cities" => $cities,
            "schools" => $schools,
            "provinces" => $provinces,
        ]);
    }
    public function create(Request $request)
    {
        $data  = (object)$request->validate([
            "firstname" => "required|string|max:255",
            "lastname" => "required|string|max:255",
            "address_line_1" => "required|string|max:255",
            "address_line_2" => "nullable|string|max:255",
            "address_line_3" => "nullable|string|max:255",
            "city" => "required|integer|exists:cities_of_sri_lankas,id",


            "tag_id" => "required|string|min:8|max:20|unique:students,tag_id",
            "local_index" => "required|string|max:20",
            "school_id" => "required|exists:schools,id",

            "phone_number_1" => ["required", "regex:/(\+*94)([0-9]{9})/i"],
            "phone_number_2" => ["nullable", "regex:/(\+*94)([0-9]{9})/i"],

            "email" => "required|email|max:255"
        ], [], [
            "school_id" => "school"
        ]);


        try {
            DB::beginTransaction();

            $student = Student::create([
                "firstname" => $data->firstname,
                "lastname" => $data->lastname,
                "address_line_1" => $data->address_line_1,
                "address_line_2" => $data->address_line_2,
                "address_line_3" => $data->address_line_3,
                "city_id" => $data->city,

                "tag_id" => $data->tag_id,
                "local_index" => $data->local_index,
                "school_id" => $data->school_id,

                "phone_number_1" => $data->phone_number_1,
                "phone_number_2" => $data->phone_number_2,

                "email" => $data->email,
                "password" => Hash::make(Str::random(10)),
            ]);


            DB::commit();

            return redirect()->route('account-manager.student-management.view', ['student' => $student->id])
                ->with(["success-message" => "Successfully created the admin."]);
        } catch (Exception $e) {
            return redirect()->back()
                ->withInput($request->all())
                ->withErrors(["error-message" => "Failed create the student, please try again."]);
        }
    }

    public function view(Student $student, Request $request)
    {
        $cities = CitiesOfSriLanka::all();
        $provinces = ProvincesOfSriLanka::all();

        $notifiablePhoneNumbers = array_filter([$student->phone_number_1, $student->phone_number_2]);
        $schools = Auth::user()->AssociatedSchools;

        return view('user-account-manager.student-management.view', [
            "cities" => $cities,
            "provinces" => $provinces,
            "schools" => $schools,
            "student" => $student,
            "notifiablePhoneNumbers" => $notifiablePhoneNumbers
        ]);
    }

    public function edit(Student $student, Request $request)
    {
        $cities = CitiesOfSriLanka::all();
        $provinces = ProvincesOfSriLanka::all();



        return view('user-account-manager.student-management.edit', [
            "cities" => $cities,
            "provinces" => $provinces,
            'student' => $student
        ]);
    }
    public function update(Student $student, Request $request)
    {

        $data  = (object)$request->validate([
            "firstname" => "required|string|max:255",
            "lastname" => "required|string|max:255",
            "address_line_1" => "required|string|max:255",
            "address_line_2" => "nullable|string|max:255",
            "address_line_3" => "nullable|string|max:255",
            "city" => "required|integer|exists:cities_of_sri_lankas,id",


            "tag_id" => "required|string|min:8|max:20|unique:students,tag_id," . $student->id,
            "local_index" => "required|string|max:20",

            "phone_number_1" => ["required", "regex:/(\+*94)([0-9]{9})/i"],
            "phone_number_2" => ["nullable", "regex:/(\+*94)([0-9]{9})/i"],

            "email" => "required|email|max:255",
            "is_active" => "required|boolean"
        ], [], [
            "school_id" => "school"
        ]);


        try {
            DB::beginTransaction();


            $student->firstname = $data->firstname;
            $student->lastname = $data->lastname;
            $student->address_line_1 = $data->address_line_1;
            $student->address_line_2 = $data->address_line_2;
            $student->address_line_3 = $data->address_line_3;
            $student->city_id = $data->city;

            $student->tag_id = $data->tag_id;
            $student->local_index = $data->local_index;

            $student->phone_number_1 = $data->phone_number_1;
            $student->phone_number_2 = $data->phone_number_2;

            $student->email = $data->email;
            $student->is_active = $data->is_active;

            $student->save();

            DB::commit();

            return redirect()->route('account-manager.student-management.view', ['student' => $student->id])
                ->with(["success-message" => "Successfully updated the student."]);
        } catch (Exception $e) {
            DB::rollBack();

            return redirect()->back()
                ->withInput($request->all())
                ->withErrors(["error-message" => "Failed update the student, please try again."]);
        }
    }


    public function attendances(Student $student, Request $request)
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


        $attendances = $student->attendances();

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

        return view('user-account-manager.student-management.attendances', [
            "student" => $student,
            "attendances" => $attendances
        ]);
    }
    public function addSchool(Student $student, Request $request)
    {
        $data = (object)$request->validate([
            "school_id" => "required|integer|exists:schools,id"
        ]);


        $student->school_id = $data->school_id;
        $student->save();

        return redirect()->back()->with(["success-message" => "Successfully associated the school."]);
    }


}
