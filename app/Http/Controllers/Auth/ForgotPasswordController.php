<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\passwordResetOTP;
use App\Models\PasswordResetTokens;
use App\Models\User;
use App\Notifications\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{
    public function index(Request $request)
    {
        return view('auth.reset-password-1');
    }

    public function verify(Request $request)
    {
        $data = (object)$request->validate([
            "email" => "required|email"
        ]);

        $user = User::where("email", $data->email)->first();

        if (!is_null($user)) {
            $token = Str::random();

            PasswordResetTokens::where("email",  $user->email)->delete();

            PasswordResetTokens::create([
                'email' => $user->email,
                'token' => Hash::make($token)
            ]);

            $user->notify(new PasswordReset($user->firstname, $token, $user->email));
        }

        return redirect()->back()->with(["message" => "Check your inbox, We have sent the required instructions to your email."]);
    }

    public function change(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "email" => "required|email|exists:users,email",
            "token" => "required|string"
        ]);


        $validator->after(function ($validator) {
            if ($validator->errors()->count() > 0) return;

            $data = (object)$validator->getData();

            $q = PasswordResetTokens::query()->where("email", $data->email)->first();
            if ($q == null) {
                $validator->errors()->add("email", "invalid");
            }
            if (!Hash::check($data->token, $q->token)) {
                $validator->errors()->add("email", "invalid");
            }
        });

        if ($validator->fails()) {
            return redirect()->route('auth.forgot-password.verify')->withErrors(["error-message" => "Invalid password reset link, please try again."]);
        }

        return view('auth.reset-password-2');
    }
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "email" => "required|string|exists:users,email",
            "token" => "required",
            "password" => "required|string|min:8|confirmed",
        ]);


        $validator->after(function ($validator) {
            if ($validator->errors()->count() > 0) return;

            $data = (object)$validator->getData();

            $q = PasswordResetTokens::query()->where("email", $data->email)->first();
            if ($q == null) {
                $validator->errors()->add("email", "invalid");
            }
            if (!Hash::check($data->token, $q->token)) {
                $validator->errors()->add("email", "invalid");
            }
        });

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors());
        }

        $data = (object)$validator->validated();

        $user = User::where("email", $data->email)->first();
        $user->password = Hash::make($data->password);
        $user->save();

        PasswordResetTokens::query()->where("email", $data->email)->delete();

        return redirect()->route('auth.forgot-password.verify')->with(["message" => "Your account password is successfully updated."]);
    }
}
