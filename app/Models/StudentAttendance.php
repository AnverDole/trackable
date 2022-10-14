<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentAttendance extends Model
{
    use HasFactory;

    public static $DIRECTION_IN = 0;
    public static $DIRECTION_OUT = 1;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        "student_id",
        "school_id",
        "direction"
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

    public function getDirectionTextAttribute()
    {
        return $this->direction == 0 ? "In" : "Out";
    }

    public function scopeIn($query)
    {
        return $query->where("direction", self::$DIRECTION_IN);
    }
    public function scopeLate($query)
    {
        return $query->whereTime('created_at', '>', '07:00:00');
    }

    public function scopeToday($query)
    {
        return $query->whereDate("created_at", date("Y-m-d"));
    }

    public function School()
    {
        return $this->belongsTo(School::class, "school_id");
    }
    public function Student()
    {
        return $this->belongsTo(Student::class, "student_id");
    }
}
