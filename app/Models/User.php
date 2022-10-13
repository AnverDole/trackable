<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    public static $USER_ROLE_SUPER_ADMIN = "super-admin";
    public static $USER_ROLE_ADMIN = "admin";
    public static $USER_ROLE_ACCOUNT_MANAGER = "account-manager";
    public static $USER_ROLE_PARENT = "user-parent";

    public static $role_ids = [
        "super-admin" => "Super Admin",
        "admin" => "Admin",
        "account-manager" => "Account Manager",
        "user-parent" => "Parent"
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'firstname',
        'lastname',
        'email',
        'role',
        'password',
        'is_active',
        'telephone',
        'address_line_1',
        'address_line_2',
        'address_line_3',
        'city_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function scopeFilterRole($query, $role)
    {
        $query->where("role", "=", $role);
    }

    public function roleText()
    {
        return self::$role_ids[$this->role];
    }

    public function City()
    {
        return $this->belongsTo(CitiesOfSriLanka::class, "city_id");
    }
    public function getAddressAttribute()
    {
        $chunks = [
            $this->address_line_1,
            $this->address_line_2,
            $this->address_line_3,
            $this->City->Province->name,
            $this->City->name,
        ];

        $chunks = array_filter($chunks);

        return join(", ", $chunks);
    }

    public function AssociatedSchools(){
        return $this->belongsToMany(School::class,"admin_associated_schools", "user_id", "school_id");
    }

    public function Childs(){
        return  $this->hasMany(Student::class, "parent_id");
    }
}
