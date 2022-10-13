<?php

namespace App\Http\Controllers\Parent;

use App\Http\Controllers\Controller;
use App\Models\CitiesOfSriLanka;
use App\Models\ProvincesOfSriLanka;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ProfileManagement extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        $cities = CitiesOfSriLanka::all();
        $provinces = ProvincesOfSriLanka::all();

        return view("user-parent.profile-management.index", [
            "cities" => $cities,
            "provinces" => $provinces,
            "user" => $user
        ]);
    }

    public function updateProfile(Request $request)
    {

        $user = Auth::user();

        $data  = (object)$request->validateWithBag("updateProfile", [
            "firstname" => "required|string|max:255",
            "lastname" => "required|string|max:255",
            "email" => "required|email|max:255|unique:users,email," . $user->id,
            "telephone" => ["required", "regex:/(0|\+*94)([0-9]{9})/i"],
            "address_line_1" => "required|string|max:255",
            "address_line_2" => "nullable|string|max:255",
            "address_line_3" => "nullable|string|max:255",
            "city" => "required|integer|exists:cities_of_sri_lankas,id"
        ]);

        try {
            DB::beginTransaction();


            $user->firstname = $data->firstname;
            $user->lastname = $data->lastname;
            $user->email = $data->email;
            $user->telephone = $data->telephone;
            $user->address_line_1 = $data->address_line_1;
            $user->address_line_2 = $data->address_line_2;
            $user->address_line_3 = $data->address_line_3;
            $user->city_id = $data->city;

            $user->save();

            DB::commit();

            return redirect()->route("parent.profile-management", ["#update-profile"])
                ->with(["update-profile-success-message" => "Successfully updated the profile information."]);
        } catch (Exception $e) {
            DB::rollBack();

            return redirect()->route("parent.profile-management", ["#update-profile"])
                ->withInput($request->all())
                ->withErrors(["update-profile-error-message" => "Failed update the profile, please try again."]);
        }
    }
    public function updatePassword(Request $request)
    {

        $user = Auth::user();

        $data  = (object)$request->validateWithBag("passwordChange", [
            "current_password" => "required|string|min:8",
            "new_password" => "required|string|min:8|confirmed"
        ]);



        if (!Hash::check($data->current_password, $user->password)) {
            return redirect()->route("parent.profile-management", ["#change-password"])
                ->withInput($request->all())
                ->withErrors(["change-pass-error-message" => "Invalid password selection."]);
        }


        try {
            DB::beginTransaction();

            $user->password = Hash::make($data->new_password);
            $user->save();

            DB::commit();

            return redirect()->route("parent.profile-management", ["#change-password"])
                ->with(["change-pass-success-message" => "Successfully changed the account password."]);
        } catch (Exception $e) {
            DB::rollBack();

            return redirect()->back()
                ->withInput($request->all())
                ->withErrors(["change-pass-error-message" => "Failed to changed the account password."]);
        }
    }
}
