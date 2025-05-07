<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AckDocRequest extends FormRequest
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


    public function rules()
    {
        return [
            'cst_ack_file' => 'required|file|mimes:pdf|max:2048',
            'invc_copy_file' => 'required|file|mimes:pdf|max:2048',
            'vhcl_reg_file' => 'required|file|mimes:pdf|max:2048',
            'evoucher_copy_file' => 'required|file|mimes:pdf|max:2048',
            'selfi_copy_file' => 'required|file|mimes:pdf|max:2048',
            'vhcl_regis_no' => 'required',
            'vihcle_dt' => 'required',
        ];
    }

    public function messages() {
        return[
            'required' => 'This field is required',
        ];
    }
}
