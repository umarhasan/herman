<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    protected $guarded = []; // ✅ All fields are now mass assignable

    protected $casts = [
        'available_days' => 'array',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function timetables()
    {
        return $this->hasMany(Timetable::class);
    }
}
