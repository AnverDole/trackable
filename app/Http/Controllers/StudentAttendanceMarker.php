<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\School;
use App\Models\StudentAttendance;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StudentAttendanceMarker extends Controller
{
    public function mark(Request $request)
    {

        $validator = Validator::make($request->all(), [
            "tag_id" => "required|string|max:255",
            "device_mac" => "required|string|regex:/^([a-fA-F0-9]{2}:){5}[a-fA-F0-9]{2}$/"
        ]);


        if ($validator->fails()) {
            return response()->json([
                "is_success" => false,
                "errors" => $validator->errors()
            ]);
        }

        $data = (object)$validator->validated();

        $data->tag_id = str_pad($data->tag_id, 10, "0", STR_PAD_LEFT);


        $school = School::whereHas("RFIDDetectors", function (Builder $query) use ($data) {
            $query->where("mac_address", $data->device_mac);
        })->first();


        if (!$school) {
            return response()->json([
                "is_success" => false,
                "errors" => ["device_mac" => "Error! Device is not valid."]
            ]);
        }

        $student = $school->Students()->where("tag_id", $data->tag_id)->first();
        if (!$student) {
            return response()->json([
                "is_success" => false,
                "errors" => ["tag_id" => "Error! RFID Tag ID is not valid."]
            ]);
        }

        $newDirection = StudentAttendance::$DIRECTION_IN;
        $lastDirection = $student->Attendances()->whereDate("created_at", date("Y-m-d"))->orderBy("id", "desc")->first()->direction ?? null;

        if ($lastDirection === StudentAttendance::$DIRECTION_IN) {
            $newDirection = StudentAttendance::$DIRECTION_OUT;
        }


        $student->Attendances()->create([
            "school_id" => $school->id,
            "direction" => $newDirection
        ]);

        return response()->json([
            "success" => true
        ], 201);
    }
}
