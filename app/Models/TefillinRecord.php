<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class TefillinRecord extends Model
{
    protected $fillable = [
        'reference_no','type','parshe_number','written_on','bought_on','bought_from',
        'paid','inspected_by','inspected_on','next_due_date','user_id','phone_number'
    ];

    protected $casts = [
        'written_on' => 'date',
        'bought_on' => 'date',
        'inspected_on' => 'date',
        'next_due_date' => 'date',
    ];

    public function user() { return $this->belongsTo(User::class); }
}