<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'teacher_id','student_id','topic','price',
        'payment_link','payment_proof','status',
        'zoom_meeting_id','zoom_join_url'
    ];

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function recordings()
    {
        return $this->hasMany(Recording::class);
    }
}