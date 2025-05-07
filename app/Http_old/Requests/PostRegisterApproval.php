<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRegisterApproval extends FormRequest
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
            'approve_doc' => 'required|file|mimes:pdf|max:1024',
            'approve_doc_date'=> 'required|date',
            'mhi_remarks' =>    'required',
        ];
    }
    
    public function messages()
    {
        return [
            'approve_doc.required' => 'The approval document is required.',
            'approve_doc.file' => 'The approval document must be a file.',
            'approve_doc.mimes' => 'The approval document must be a PDF file.',
            'approve_doc.max' => 'The approval document may not be greater than 1MB.',
            
            'approve_doc_date.required' => 'The approval document date is required.',
            'approve_doc_date.date' => 'The approval document date must be a valid date.',
            
            'mhi_remarks.required' => 'MHI remarks are required.',
        ];
    }
}
