<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class MezuzaRecord extends Model
{
    protected $fillable = [
        'location',
        'house_number',
        'room_number',
        'street_number',
        'street_name',
        'area_name',
        'city',
        'country',
        'door_description',
        'written_on',
        'bought_from',
        'bought_from_phone_code',
        'bought_from_phone_number',
        'paid',
        'inspected_by',
        'inspected_on',
        'reminder_email_on',
        'condition',
        'notes',
        'reference_no',
        'next_due_date',
        'user_id',
    ];

    protected $casts = [
        'written_on' => 'date',
        'inspected_on' => 'date',
        'next_due_date' => 'date',
        'reminder_email_on' => 'date',
    ];

    public function user() { return $this->belongsTo(User::class); }
}