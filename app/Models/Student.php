<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User;
use Illuminate\Notifications\Notifiable;

class Student extends User
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'firstname',
        'lastname',
        'address_line_1',
        'address_line_2',
        'address_line_3',
        'city_id',
        'tag_id',
        'school_id',
        'parent_id',
        'local_index',
        'is_active'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [];


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


    public function School()
    {
        return $this->belongsTo(School::class, "school_id");
    }
    public function Parent()
    {
        return $this->belongsTo(User::class, "parent_id");
    }

    public function Attendances()
    {
        return $this->hasMany(StudentAttendance::class,  "student_id");
    }

    public function scopeActive($query)
    {
        return $query->where("is_active", true);
    }
}
