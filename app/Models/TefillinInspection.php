<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class TefillinInspection extends Model
{
    protected $fillable = [
        'user_id','side','part_name','date_of_buy','next_inspection_date','status','image'
    ];

    protected $casts = [
        'date_of_buy' => 'date',
        'next_inspection_date' => 'date',
    ];

    // Relation
    public function user() {
        return $this->belongsTo(User::class);
    }

    // Auto set next_inspection_date = date_of_buy + 3.5 years
    protected static function booted() {
        static::saving(function ($model) {
            if ($model->date_of_buy && !$model->next_inspection_date) {
                $model->next_inspection_date = Carbon::parse($model->date_of_buy)->addYears(3)->addMonths(6);
            }
        });
    }
}
