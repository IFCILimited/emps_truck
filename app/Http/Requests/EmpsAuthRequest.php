<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmpsAuthRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
           'evoucher_copy_file' => 'required|mimes:pdf|max:2048',
           'cust_selfie_copy' => 'required|mimes:pdf|max:2048',
        ];
    }
    public function messages()
    {
        return [
            'required' => 'This field is required',
            'mimes' => 'The customer file copy must be a PDF file.',
            'max' => 'The customer file copy may not be greater than 2MB in size.',
        ];
    }
}
