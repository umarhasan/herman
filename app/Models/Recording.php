<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Recording extends Model
{
    protected $fillable = ['booking_id','title','file_url','file_type','status'];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    // return full public url helper
    public function publicUrl()
    {
        return asset('storage/' . $this->file_path);
    }
}