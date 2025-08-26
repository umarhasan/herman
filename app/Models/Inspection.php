<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Inspection extends Model
{
    protected $guarded = [];

    protected $casts = [
        'date_of_inspection'   => 'date',
        'next_inspection_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Auto calculate next_inspection_date = date_of_inspection + 3 years 6 months
    protected static function booted()
    {
        static::saving(function ($model) {
            if ($model->date_of_inspection && !$model->next_inspection_date) {
                $model->next_inspection_date = Carbon::parse($model->date_of_inspection)
                    ->addYears(3)
                    ->addMonths(6);
            }
        });
    }
}
