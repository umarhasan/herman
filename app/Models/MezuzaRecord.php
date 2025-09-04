<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class MezuzaRecord extends Model
{
    protected $fillable = [
        'location',
        'door_description',        // added
        'reference_no',
        'written_on',
        'bought_from',
        'bought_from_phone',       // added
        'paid',
        'inspected_by',
        'inspected_on',
        'next_due_date',
        'reminder_email_on',
        'condition',
        'notes',
        'user_id'
    ];

    protected $casts = [
        'written_on' => 'date',
        'inspected_on' => 'date',
        'next_due_date' => 'date',
        'reminder_email_on' => 'date',
    ];

    public function user() { return $this->belongsTo(User::class); }
}