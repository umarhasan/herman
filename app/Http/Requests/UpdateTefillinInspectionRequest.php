<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTefillinInspectionRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'side' => 'nullable|in:left,right,head',
            'part_name' => 'required|in:A,B,C,D',
            'date_of_buy' => 'required|date',
            'status' => 'nullable|in:active,removed',
        ];
    }
}
