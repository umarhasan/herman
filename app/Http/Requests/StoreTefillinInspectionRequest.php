<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTefillinInspectionRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'user_id' => 'required|exists:users,id',
            'side' => 'nullable|in:left,right,head',
            'part_name' => 'required|in:A,B,C,D',
            'date_of_buy' => 'required|date',
        ];
    }
}