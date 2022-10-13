<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
            $email = $user->email;
        }

        return redirect()->back()->with(["message" => "Check your inbox, We have sent the required instructions to your email."]);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "email" => "required|email"
        ]);

        return view('auth.reset-password-2');
    }
}
