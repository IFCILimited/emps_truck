<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRegistrationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; // Assuming authorization is handled elsewhere
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            // Registration Form
            // 'oem_name' => 'required|string|max:255',
            // 'oem_type' => 'required|string|in:Proprietorship,Partnership/LLP,Company',
            // 'username' => 'required|string|max:255|unique:users',
            'password' => [
                'required',
                'string',
                'min:8',
                'max:15',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,15}$/',
            ],

            'password_confirmation' => 'required|string|same:password',

            // Manufacturing Information
            // 'company_registration_no' => 'required|string|max:255',
            // 'company_registration_certificate' => 'required|file',
            // 'gstin_no' => 'required|string|max:255',
            'gstin_no' => ['required', 'string', 'max:255', 'regex:/^\d{2}[A-Z]{5}\d{4}[A-Z]{1}\d[Z]{1}[A-Z\d]{1}$/'],
            'gstin_registration_file' => 'required|file|mimes:pdf|max:1024',
            'registration_certificate_upload_id' => 'required|file|mimes:pdf|max:1024',
            'oem_pan' => 'required|string|max:255',
            'oem_pan_file' => 'required|file|mimes:pdf|max:1024',
            'r_and_d_facilities_file' => 'required|file|mimes:pdf|max:1024',

            'annual_turnover' => 'required|numeric',

            // Registered Office Wizard
            // 'registered_office_address' => 'required|string|max:255',
            // 'registered_office_city' => 'required|string|max:255',
            'registered_office_landmark' => 'required|string|max:255',
            // 'registered_office_pincode' => 'required|string|max:255',
            // 'registered_office_state' => 'required|string|max:255',
            'registered_office_landline_no' => 'nullable|string|digits_between:8,12',

            // 'registered_office_district' => 'required|string|max:255',
            // 'registered_office_fax_no' => 'required|string|max:255',
            // 'registered_office_email' => 'required|email|max:255',

            // Manufacturing Plants Wizard (assuming it's dynamic)
            'evplant.*.plant_name' => 'required|string|max:255',
            'evplant.*.plant_address' => 'required|string|max:255',
            'evplant.*.plant_email' => 'required|email|max:255',
            'evplant.*.plant_state' => 'required|string|max:255',
            'evplant.*.plant_district' => 'required|string|max:255',
            'evplant.*.plant_city' => 'required|string|max:255',
            'evplant.*.plant_pincode' => 'required|string|max:255',
            'evplant.*.plant_landline' => 'required|string|numeric|digits_between:8,12',

            // Authorized Person Details Wizard
            'authorized_person_name' => 'required|string|max:255',
            'authorized_person_city' => 'required|string|max:255',
            'authorized_person_address' => 'required|string|max:255',
            'authorized_person_landmark' => 'required|string|max:255',
            'authorized_person_pincode' => 'required|string|max:255',
            'authorized_person_mobile' => 'required|numeric|digits_between:10,10',
            'authorized_person_district' => 'required|string|max:255',
            'authorized_person_state' => 'required|string|max:255',
            // 'authorized_person_fax' => 'required|string|max:255',
            'authorized_person_email' => 'required|email|max:255',

            // Bank Details Wizard
            'ifsc_code' => 'required|string|max:255',
            'account_holder_name' => 'required|string|max:255',
            'bank_name' => 'required|string|max:255',
            'branch_name' => 'required|string|max:255',
            'bank_address' => 'required|string|max:255',
            'branch_state' => 'required|string|max:255',
            'branch_district' => 'required|string|max:255',
            'branch_city' => 'required|string|max:255',
            'account_number' => 'required',
            'branch_pincode' => 'required',
            'micr_code' => 'required|string|max:255',
            'account_type' => 'required',

            'vehicle_photo' => 'required|file|mimes:pdf|max:2000',
            'moa_aoa' => 'required|file|mimes:pdf|max:2000',
            'trade_license' => 'required|file|mimes:pdf|max:2000',
            'manufacturer_registration' => 'required|file|mimes:pdf|max:2000',
            'pre_registration_ev_model' => 'required|file|mimes:pdf|max:2000',
            'oem_sales_and_service_network' => 'required|file|mimes:pdf|max:2000',
            'tesed_homologation_certificate' => 'required|file|mimes:pdf|max:2000',

            // Other Details Wizard
            'dealer_mode' => 'required',
            'dealer_numbers' => 'required',
            'no_of_dealer' => 'required|integer',
            'dealer_list_file' => 'required|file|mimes:xls,xlsx|max:1024',
            'state_of_dealer_presence' => 'required',

            // Declaration
            'declaration' => 'required',
        ];
    }

    public function messages()
    {
        return [
            // Registration Form
            'password.required' => 'The password field is required.',
            'password.min' => 'The password must be at least :min characters.',
            'password.max' => 'The password may not be greater than :max characters.',
            'password.confirmed' => 'The password confirmation does not match.',
            'password_confirmation.required' => 'The password confirmation field is required.',

            // Manufacturing Information
            'company_registration_no.required' => 'The company registration number field is required.',
            'company_registration_certificate.required' => 'The company registration certificate field is required.',
            'company_registration_certificate.file' => 'The company registration certificate must be a file.',
            'gstin_no.required' => 'The GSTIN number field is required.',
            'gstin_registration_file.required' => 'The GSTIN registration file field is required.',
            'gstin_registration_file.file' => 'The GSTIN registration file must be a file.',
            'oem_pan.required' => 'The OEM PAN field is required.',
            'oem_pan_file.required' => 'The OEM PAN file field is required.',
            'oem_pan_file.file' => 'The OEM PAN file must be a file.',
            'r_and_d_facilities_file.required' => 'The R&D facilities file field is required.',
            'r_and_d_facilities_file.file' => 'The R&D facilities file must be a file.',
            'annual_turnover.required' => 'The annual turnover field is required.',
            'annual_turnover.numeric' => 'The annual turnover must be a number.',
            'oem_pan_file.required' => 'The oem_pan_file field is required.',
            'oem_pan_file.file' => 'The oem_pan_file must be a file.',
            'oem_pan_file.mimes' => 'The oem_pan_file must be a PDF file.',
            'oem_pan_file.max' => 'The oem_pan_file must not exceed :max kilobytes (KB).',

            'r_and_d_facilities_file.required' => 'The r_and_d_facilities_file field is required.',
            'r_and_d_facilities_file.file' => 'The r_and_d_facilities_file must be a file.',
            'r_and_d_facilities_file.mimes' => 'The r_and_d_facilities_file must be a PDF file.',
            'r_and_d_facilities_file.max' => 'The r_and_d_facilities_file must not exceed :max kilobytes (KB).',
            // Registered Office Wizard
            'registered_office_address.required' => 'The registered office address field is required.',
            'registered_office_address.string' => 'The registered office address must be a string.',
            'registered_office_address.max' => 'The registered office address may not be greater than :max characters.',
            'registered_office_city.required' => 'The registered office city field is required.',
            'registered_office_city.string' => 'The registered office city must be a string.',
            'registered_office_city.max' => 'The registered office city may not be greater than :max characters.',
            'registered_office_landmark.required' => 'The registered office landmark field is required.',
            'registered_office_landmark.string' => 'The registered office landmark must be a string.',
            'registered_office_landmark.max' => 'The registered office landmark may not be greater than :max characters.',
            'registered_office_pincode.required' => 'The registered office pincode field is required.',
            'registered_office_pincode.string' => 'The registered office pincode must be a string.',
            'registered_office_pincode.max' => 'The registered office pincode may not be greater than :max characters.',
            'registered_office_state.required' => 'The registered office state field is required.',
            'registered_office_state.string' => 'The registered office state must be a string.',
            'registered_office_state.max' => 'The registered office state may not be greater than :max characters.',
            'registered_office_landline_no.required' => 'The registered office landline number field is required.',
            'registered_office_landline_no.string' => 'The registered office landline number must be a string.',
            'registered_office_landline_no.digits_between' => 'The registered office landline number may not be greater than :min and :max characters.',
            'registered_office_landline_no.numeric' => 'The registered office landline number is numeric.',
            'registered_office_district.required' => 'The registered office district field is required.',
            'registered_office_district.string' => 'The registered office district must be a string.',
            'registered_office_district.max' => 'The registered office district may not be greater than :max characters.',
            'registered_office_fax_no.required' => 'The registered office fax number field is required.',
            'registered_office_fax_no.string' => 'The registered office fax number must be a string.',
            'registered_office_fax_no.max' => 'The registered office fax number may not be greater than :max characters.',
            'registered_office_email.required' => 'The registered office email field is required.',
            'registered_office_email.email' => 'The registered office email must be a valid email address.',
            'registered_office_email.max' => 'The registered office email may not be greater than :max characters.',


            // Manufacturing Plants Wizard
            'evplant.*.plant_name.required' => 'The plant name field is required.',
            'evplant.*.plant_name.string' => 'The plant name must be a string.',
            'evplant.*.plant_name.max' => 'The plant name may not be greater than :max characters.',
            'evplant.*.plant_address.required' => 'The plant address field is required.',
            'evplant.*.plant_address.string' => 'The plant address must be a string.',
            'evplant.*.plant_address.max' => 'The plant address may not be greater than :max characters.',
            'evplant.*.plant_email.required' => 'The plant email field is required.',
            'evplant.*.plant_email.email' => 'The plant email must be a valid email address.',
            'evplant.*.plant_email.max' => 'The plant email may not be greater than :max characters.',
            'evplant.*.plant_state.required' => 'The plant state field is required.',
            'evplant.*.plant_state.string' => 'The plant state must be a string.',
            'evplant.*.plant_state.max' => 'The plant state may not be greater than :max characters.',
            'evplant.*.plant_district.required' => 'The plant district field is required.',
            'evplant.*.plant_district.string' => 'The plant district must be a string.',
            'evplant.*.plant_district.max' => 'The plant district may not be greater than :max characters.',
            'evplant.*.plant_city.required' => 'The plant city field is required.',
            'evplant.*.plant_city.string' => 'The plant city must be a string.',
            'evplant.*.plant_city.max' => 'The plant city may not be greater than :max characters.',
            'evplant.*.plant_pincode.required' => 'The plant pincode field is required.',
            'evplant.*.plant_pincode.string' => 'The plant pincode must be a string.',
            'evplant.*.plant_pincode.max' => 'The plant pincode may not be greater than :max characters.',
            'evplant.*.plant_landline.required' => 'The plant landline field is required.',
            'evplant.*.plant_landline.string' => 'The plant landline must be a string.',
            'evplant.*.plant_landline.digits_between' => 'The plant landline may not be greater than :min and :max characters.',
            'evplant.*.plant_landline.numeric' => 'The plant landline is numeric.',


            // Authorized Person Details Wizard
            'authorized_person_name.required' => 'The authorized person name field is required.',
            'authorized_person_name.string' => 'The authorized person name must be a string.',
            'authorized_person_name.max' => 'The authorized person name may not be greater than :max characters.',
            'authorized_person_city.required' => 'The authorized person city field is required.',
            'authorized_person_city.string' => 'The authorized person city must be a string.',
            'authorized_person_city.max' => 'The authorized person city may not be greater than :max characters.',
            // Add custom messages for other fields as needed...

            // Bank Details Wizard
            'ifsc_code.required' => 'The IFSC code field is required.',
            'ifsc_code.string' => 'The IFSC code must be a string.',
            'ifsc_code.max' => 'The IFSC code may not be greater than :max characters.',
            // Add custom messages for other fields as needed...

            'vehicle_photo.required' => 'The photograph of the approved vehicles is required.',
            'vehicle_photo.file' => 'The photograph of the approved vehicles must be a file.',
            'vehicle_photo.mimes' => 'The photograph of the approved vehicles must be a file of type: pdf.',
            'vehicle_photo.max' => 'The photograph of the approved vehicles may not be greater than 2Mb.',

            'moa_aoa.required' => 'The MOA & AOA document is required.',
            'moa_aoa.file' => 'The MOA & AOA must be a file.',
            'moa_aoa.mimes' => 'The MOA & AOA must be a file of type: pdf.',
            'moa_aoa.max' => 'The MOA & AOA may not be greater than 2Mb.',

            'trade_license.required' => 'The trade license document is required.',
            'trade_license.file' => 'The trade license must be a file.',
            'trade_license.mimes' => 'The trade license must be a file of type: pdf.',
            'trade_license.max' => 'The trade license may not be greater than 2Mb.',

            'manufacturer_registration.required' => 'The manufacturer registration (Annexure-I) document is required.',
            'manufacturer_registration.file' => 'The manufacturer registration (Annexure-I) must be a file.',
            'manufacturer_registration.mimes' => 'The manufacturer registration (Annexure-I) must be a file of type: pdf.',
            'manufacturer_registration.max' => 'The manufacturer registration (Annexure-I) may not be greater than 2Mb.',

            'pre_registration_ev_model.required' => 'The pre-registration of EV model (Annexure-II) document is required.',
            'pre_registration_ev_model.file' => 'The pre-registration of EV model (Annexure-II) must be a file.',
            'pre_registration_ev_model.mimes' => 'The pre-registration of EV model (Annexure-II) must be a file of type: pdf.',
            'pre_registration_ev_model.max' => 'The pre-registration of EV model (Annexure-II) may not be greater than 2Mb.',

            'oem_sales_and_service_network.required' => 'The OEM’s sales and service network document is required.',
            'oem_sales_and_service_network.file' => 'The OEM’s sales and service network must be a file.',
            'oem_sales_and_service_network.mimes' => 'The OEM’s sales and service network must be a file of type: pdf.',
            'oem_sales_and_service_network.max' => 'The OEM’s sales and service network may not be greater than 2Mb.',

            'tesed_homologation_certificate.required' => 'The testing/homologation certificate is required.',
            'tesed_homologation_certificate.file' => 'The testing/homologation certificate must be a file.',
            'tesed_homologation_certificate.mimes' => 'The testing/homologation certificate must be a file of type: pdf.',
            'tesed_homologation_certificate.max' => 'The testing/homologation certificate may not be greater than 2Mb.',

            'registration_certificate_upload_id.required' => 'The company registration certificate is required.',
            'registration_certificate_upload_id.file' => 'The company registration certificate must be a file.',
            'registration_certificate_upload_id.mimes' => 'The company registration certificate must be a file of type: pdf.',
            'registration_certificate_upload_id.max' => 'The company registration certificate may not be greater than 1Mb.',

            // Other Details Wizard
            'dealer_mode.required' => 'The dealer mode field is required.',
            'dealer_mode.string' => 'The dealer mode must be a string.',
            'dealer_mode.in' => 'The selected dealer mode is invalid.',
            'dealer_numbers.required' => 'The dealer numbers field is required.',
            'dealer_numbers.string' => 'The dealer numbers must be a string.',
            'dealer_numbers.in' => 'The selected dealer numbers is invalid.',
            'no_of_dealer.required' => 'The number of dealers field is required.',
            'no_of_dealer.integer' => 'The number of dealers must be an integer.',
            // Add custom messages for other fields as needed...
            'max' => 'The :attribute must not exceed :max kilobytes (KB).',

            // Declaration
            'declaration.required' => 'You must accept the declaration to proceed.',

            // Add more custom messages as needed...
        ];
    }
}
