<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendances extends Model
{
    protected $fillable = [
        'student_id',
        'subject_id',
        'school_class_id',
        'teacher_id',
        'date',
        'status'
    ];

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }
    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }
    public function class()
    {
        return $this->belongsTo(SchoolClass::class, 'school_class_id');
    }
    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }
}
