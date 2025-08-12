<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Meeting extends Model {
    protected $fillable = ['booking_id','topic','start_time','duration','zoom_meeting_id','join_url','start_url'];
    public function booking(){ return $this->belongsTo(Booking::class); }
}