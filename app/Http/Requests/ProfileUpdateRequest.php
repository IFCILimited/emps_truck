<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileUpdateRequest extends FormRequest
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
            'manu_reg' => 'required|mimes:pdf|max:2048',
            'comp_reg' => 'required|mimes:pdf|max:2048',
            'ofc_reg' => 'required|mimes:pdf|max:2048',
            'trade_lic' => 'required|mimes:pdf|max:2048',
            'gst_reg' => 'required|mimes:pdf|max:2048',
            'pan_card' => 'required|mimes:pdf|max:2048',
            'moa_aoa' => 'required|mimes:pdf|max:2048',
            'sales_net' => 'required|mimes:pdf|max:2048',
            'photo_veh' => 'required|mimes:pdf|max:2048',
            'res_letter' => 'required|mimes:pdf|max:2048',
            'auth_letter' => 'required|mimes:pdf|max:2048',
            'bank_det' => 'required|mimes:pdf|max:2048',
            'rd_fac' => 'required|mimes:pdf|max:2048',
            'auth_sig' => 'required|mimes:pdf|max:2048',
        ];
    }

    public function messages()
    {
        return [
            'required' => 'The field is required.',
            'max' => 'The must not exceed :max kb.',
            'mimes' => 'The must be a file of type: :values.',
        ];
    }
}
