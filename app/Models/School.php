<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        "name",
        "email",
        "telephone",
        "address_line_1",
        "address_line_2",
        "address_line_3",
        "city_id"
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

    public function Students()
    {
        return $this->hasMany(Student::class, "school_id");
    }

    public function AssociatedAccountManagers()
    {
        return $this->belongsToMany(User::class, "admin_associated_schools", "school_id", "user_id");
    }
    public function Attendances()
    {
        return $this->hasMany(StudentAttendance::class,  "school_id");
    }

    public function RFIDDetectors()
    {
        return $this->hasMany(RFIDDetector::class, "school_id");
    }
}
