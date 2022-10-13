<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function index(Request $request)
    {
        return view('auth.sign-in');
    }

    public function login(Request $request)
    {

        $validator = Validator::make($request->all(), [
            "email" => "required|email|exists:users,email",
            "password" => "required",
            "remember_me" => "string"
        ]);


        if ($validator->fails()) {
            return back()->withErrors(["email" => "Given credentials do not match."])
                ->withInput($request->only(["email"]));
        }

        $data  = $validator->validated();

        if (Auth::attempt($data, ($data["remember_me"] ?? null) == "on")) {
            $request->session()->regenerate();;
            $intended_url = redirect()->intended(route(RouteServiceProvider::mainRouteNameByUserRole()))->getTargetUrl();

            return redirect()->to($intended_url);
        } else {
            return back()->withErrors(["email" => "Given credentials do not match."])
                ->withInput($request->only(["email"]));
        }
    }
}
