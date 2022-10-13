<?php

use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get("/", function () {
    $to = RouteServiceProvider::mainRouteNameByUserRole();
    if (!$to)  return redirect()->route("auth.login");
    return redirect()->route($to);
});

Route::middleware("guest")->group(function () {
    Route::get("/auth/sign-in", "Auth\LoginController@index")->name("auth.login");
    Route::post("/auth/sign-in", "Auth\LoginController@login")->middleware("throttle:10,1,auth.login");

    Route::get("/auth/forgot-password/verify", "Auth\ForgotPasswordController@index")->name("auth.forgot-password.verify");
    Route::post("/auth/forgot-password/verify", "Auth\ForgotPasswordController@verify")->middleware("throttle:10,1,auth.forgot-password.verify");

    Route::get("/auth/forgot-password/change", "Auth\ForgotPasswordController@index")->name("auth.forgot-password.change");
    Route::post("/auth/forgot-password", "Auth\LoginController@update")->name("auth.forgot-password.change")->middleware("throttle:10,1");
});

Route::middleware("auth")->group(function () {
    Route::post("/auth/sign-out", "Auth\SignOutController@signout")->name("auth.signout");
});

Route::middleware("auth.role:super-admin")->prefix("admin")->group(function () {
    Route::get("/admin-management", "SysAdmin\AdminManagement@index")->name("admin-management");
    Route::get("/admin-management/new", "SysAdmin\AdminManagement@new")->name("admin-management.new");
    Route::post("/admin-management/new", "SysAdmin\AdminManagement@create");
    Route::get("/admin-management/{admin}", "SysAdmin\AdminManagement@view")->name("admin-management.view");
    Route::get("/admin-management/{admin}/edit", "SysAdmin\AdminManagement@edit")->name("admin-management.edit");
    Route::post("/admin-management/{admin}/edit", "SysAdmin\AdminManagement@update");

    Route::post("/admin-management/{admin}/associate-school", "SysAdmin\AdminManagement@addSchool")->name('admin-management.school.associate');
    Route::post("/admin-management/{admin}/dissociate-school", "SysAdmin\AdminManagement@removeSchool")->name('admin-management.school.dissociate');

    Route::post("/admin-management/select-admin", "SysAdmin\AdminManagement@getAdmins")->name('admin-management.select-admin');
});
Route::middleware("auth.role:super-admin,admin")->prefix("admin")->group(function () {
    Route::get("/dashboard", "SysAdmin\DashboardController@index")->name("sys.admin.dashboard");

    Route::get("/school-management", "SysAdmin\SchoolManagement@index")->name("school-management");



    Route::get("/school-management/new", "SysAdmin\SchoolManagement@new")->name("school-management.new");
    Route::post("/school-management/new", "SysAdmin\SchoolManagement@create");

    Route::get("/school-management/{school}", "SysAdmin\SchoolManagement@view")->name("school-management.view");
    Route::post("/school-management/{school}/associate-admin", "SysAdmin\SchoolManagement@addAdmin")->name("school-management.admin.associate");
    Route::post("/school-management/{school}/dissociate-admin", "SysAdmin\SchoolManagement@removeAdmin")->name("school-management.admin.dissociate");

    Route::get("/school-management/{school}/edit", "SysAdmin\SchoolManagement@edit")->name("school-management.edit");
    Route::post("/school-management/{school}/edit", "SysAdmin\SchoolManagement@update");


    Route::post("/school-management/select-school", "SysAdmin\SchoolManagement@getSchools")->name('school-management.select-school');

    Route::get("/school-management/schools/{school}/students", "SysAdmin\SchoolManagement@students")->name("school-management.students");
    Route::get("/student-management/schools/{school}/attendances", "SysAdmin\SchoolManagement@attendances")->name("school-management.view.attendances");


    Route::get("/student-management", "SysAdmin\StudentManagement@index")->name("student-management");
    Route::get("/student-management/new", "SysAdmin\StudentManagement@new")->name("student-management.new");
    Route::post("/student-management/new", "SysAdmin\StudentManagement@create");
    Route::get("/student-management/{student}", "SysAdmin\StudentManagement@view")->name("student-management.view");
    Route::get("/student-management/{student}/edit", "SysAdmin\StudentManagement@edit")->name("student-management.edit");
    Route::post("/student-management/{student}/edit", "SysAdmin\StudentManagement@update");

    Route::get("/student-management/{student}/attendances", "SysAdmin\StudentManagement@attendances")->name("student-management.view.attendances");

    Route::post("/student-management/parents", "SysAdmin\StudentManagement@parents")->name("student-management.parents");
    Route::get("/student-management/parents/new", "SysAdmin\ParentManagement@new")->name("student-management.parents.new");
    Route::post("/student-management/parents/new", "SysAdmin\ParentManagement@create");

    Route::post("/student-management/{student}/associate-school", "SysAdmin\StudentManagement@addSchool")->name('student-management.school.associate');

    Route::get("/profile-management", "SysAdmin\ProfileManagement@index")->name("profile-management");
    Route::post("/profile-management/edit", "SysAdmin\ProfileManagement@updateProfile")->name("profile-management.edit");

    Route::post("/profile-management/update-password", "SysAdmin\ProfileManagement@updatePassword")->name("profile-management.update-password");
});

Route::middleware("auth.role:account-manager")->prefix("account-manager")->group(function () {
    Route::get("/dashboard", "AccountManager\DashboardController@index")->name("account-manager.dashboard");

    Route::get("/school-management", "AccountManager\SchoolManagement@index")->name("account-manager.school-management");
    Route::get("/school-management/{school}", "AccountManager\SchoolManagement@view")->name("account-manager.school-management.view");
    Route::get("/school-management/{school}/edit", "AccountManager\SchoolManagement@edit")->name("account-manager.school-management.edit");
    Route::post("/school-management/{school}/edit", "AccountManager\SchoolManagement@update");


    Route::get("/school-management/schools/{school}/students", "AccountManager\SchoolManagement@students")->name("account-manager.school-management.students");
    Route::get("/student-management/schools/{school}/attendances", "AccountManager\SchoolManagement@attendances")->name("account-manager.school-management.view.attendances");


    Route::get("/student-management", "AccountManager\StudentManagement@index")->name("account-manager.student-management");
    Route::get("/student-management/new", "AccountManager\StudentManagement@new")->name("account-manager.student-management.new");
    Route::post("/student-management/new", "AccountManager\StudentManagement@create");
    Route::get("/student-management/{student}", "AccountManager\StudentManagement@view")->name("account-manager.student-management.view");
    Route::get("/student-management/{student}/edit", "AccountManager\StudentManagement@edit")->name("account-manager.student-management.edit");
    Route::post("/student-management/{student}/edit", "AccountManager\StudentManagement@update");


    Route::get("/student-management/{student}/attendances", "AccountManager\StudentManagement@attendances")->name("account-manager.student-management.view.attendances");
    Route::post("/student-management/{student}/associate-school", "AccountManager\StudentManagement@addSchool")->name('account-manager.student-management.school.associate');

    Route::get("/profile-management", "AccountManager\ProfileManagement@index")->name("account-manager.profile-management");
    Route::post("/profile-management/edit", "AccountManager\ProfileManagement@updateProfile")->name("account-manager.profile-management.edit");
    Route::post("/profile-management/update-password", "AccountManager\ProfileManagement@updatePassword")->name("account-manager.profile-management.update-password");


    Route::get("/admin-management/{admin}", "AccountManager\AdminManagement@view")->name("account-manager.admin-management.view");
});

Route::middleware("auth.role:user-parent")->prefix("parent")->group(function () {
    Route::get("/dashboard", "Parent\DashboardController@index")->name("parent.dashboard");
    Route::get("/attendances/{student}", "Parent\AttendanceController@index")->name("parent.attendances");

    Route::get("/profile-management", "Parent\ProfileManagement@index")->name("parent.profile-management");
    Route::post("/profile-management/edit", "Parent\ProfileManagement@updateProfile")->name("parent.profile-management.edit");

    Route::post("/profile-management/update-password", "Parent\ProfileManagement@updatePassword")->name("parent.profile-management.update-password");
});
