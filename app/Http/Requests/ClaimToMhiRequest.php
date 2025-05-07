<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClaimToMhiRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'month' => 'required|integer|min:1|max:12',
            // 'check' => 'required|array',
        ];
    }

    public function messages()
    {
        return [
            'month.required' => 'The month field is required.',
            'month.integer' => 'The month must be a valid number.',
            'month.min' => 'The month must be at least 1.',
            'month.max' => 'The month may not be greater than 12.',
            // 'check.required' => 'Please select at least one claim.'
        ];
    }
}
