<?php

namespace App\Http\Controllers\SysAdmin;

use App\Http\Controllers\Controller;
use App\Models\CitiesOfSriLanka;
use App\Models\ProvincesOfSriLanka;
use App\Models\Student;
use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

        return view('user-system-admin.student-management.index', [
            "cities" => $cities,
            "students" => $students
        ]);
    }
    public function new(Request $request)
    {
        $cities = CitiesOfSriLanka::all();
        $provinces = ProvincesOfSriLanka::all();

        return view('user-system-admin.student-management.new', [
            "cities" => $cities,
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
            "school_id" => "required|integer|exists:schools,id",
            "parent_id" => "required|integer|exists:users,id",
        ], [], [
            "school_id" => "school",
            "parent_id" => "parent"
        ]);


        if (User::findorfail($data->parent_id)->role !== User::$USER_ROLE_PARENT) {
            return redirect()->back()
                ->withInput($request->all())
                ->withErrors(["error-message" => "Given parent account reference is invalid."]);
        }


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
                "parent_id" => $data->parent_id
            ]);

            DB::commit();

            return redirect()->route('student-management.view', ['student' => $student->id])
                ->with(["success-message" => "Successfully created the admin."]);
        } catch (Exception $e) {
            dd($e->getMessage());
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

        return view('user-system-admin.student-management.view', [
            "cities" => $cities,
            "provinces" => $provinces,
            "student" => $student,
            "notifiablePhoneNumbers" => $notifiablePhoneNumbers
        ]);
    }

    public function edit(Student $student, Request $request)
    {
        $cities = CitiesOfSriLanka::all();
        $provinces = ProvincesOfSriLanka::all();


        return view('user-system-admin.student-management.edit', [
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

            "school_id" => "required|integer|exists:schools,id",
            "parent_id" => "required|integer|exists:users,id",
            "is_active" => "required|integer|in:0,1",
        ], [], [
            "school_id" => "school",
            "parent_id" => "parent"
        ]);


        if (User::findorfail($data->parent_id)->role !== User::$USER_ROLE_PARENT) {
            return redirect()->back()
                ->withInput($request->all())
                ->withErrors(["error-message" => "Given parent account reference is invalid."]);
        }


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


            $student->is_active = $data->is_active;
            $student->parent_id = $data->parent_id;

            $student->save();

            DB::commit();


            return redirect()->route('student-management.view', ['student' => $student->id])
                ->with(["success-message" => "Successfully updated the student."]);
        } catch (Exception $e) {
            DB::rollBack();

            return redirect()->back()
                ->withInput($request->all())
                ->withErrors(["error-message" => "Failed update the student, please try again."]);
        }
    }

    public function parents(Request $request)
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

        return view('user-system-admin.student-management.attendances', [
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
