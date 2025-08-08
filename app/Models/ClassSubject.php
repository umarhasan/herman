<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClassSubject extends Model
{
    protected $table = 'class_subject';
    protected $fillable = ['school_class_id', 'subject_id'];

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }


    public function schoolClass()
    {
        return $this->belongsTo(SchoolClass::class, 'school_class_id');
    }
}
