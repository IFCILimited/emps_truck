<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use App\Models\DealerRegistration;
use Illuminate\Validation\Rule; // Import Rule
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use App\Models\User;
use Auth;
use Hash;
use Mail;

class BulkDealerImport implements ToCollection, WithHeadingRow, WithValidation
{
    public function collection(Collection $rows)
    {
        // dd($rows);
        $pid = getParentId();
        foreach ($rows as $row) {
            // dd($row);
            $password = generatePassword();
            $username = generateUsername($row['dealer_name'], $row['mobile_no']);
            $user = User::create([
                'oem_id' => $pid,
                'name' => $row['dealer_name'],
                'username' =>  $username,
                'password' => Hash::make($password),
                'dealer_code' => $row['dealer_code'],
                'dealer_gstin_no' => $row['gstin_number'],
                'auth_name' => $row['authorized_person_name'],
                'address' => $row['address'],
                'pincode' => $row['pin_code'],
                'state' => $row['state'],
                'district' => $row['district'],
                'landmark' => $row['landmark'],
                'landline' => $row['landline_no'],
                'mobile' => $row['mobile_no'],
                'fax' => $row['fax_no'],
                'email' => $row['email_id'],
                'isotpverified' => 0,
                'isactive' => 'Y',
                'isapproved' => 'Y',

            ]);

            $user->assignRole('DEALER-Truck');

            $userData = $user->where('id', $user->id)->first();

                $userMail = array (
                    'name' => $user->name,
                    'email' => $user->email,
                    'status' => 'Login Credential Successfully Create',
                    'username' => $userData->username,
                    'password' => $password
                );
                // Mail::send('emails.Credential', $userMail, function ($message) use ($userMail) {
                //     $message->to($userMail['email'])->subject($userMail['status']);
                // });
                $to = $userMail['email'];
                $cc= '';
                $bcc='';
                $subject=$userMail['status'];
                // $from = 'noreply.pmedrive@heavyindustry.gov.in';
                $msg=view('emails.Credential', ['user' => $userMail])->render();

                $response = sendMail($to,$cc,$bcc,$subject,$msg);
        }
    }

    public function rules(): array
    {
        return [
            'dealer_name' => ['required', 'string', 'max:255'],
            'dealer_code' => ['required', 'max:255'],
            'gstin_number' => ['required', 'regex:/^\d{2}[A-Z]{5}\d{4}[A-Z]{1}\d[Z]{1}[A-Z\d]{1}$/'],
            // 'gstin_number' => ['required', 'regex:/^\d{2}[A-Z]{5}\d{4}[A-Z]{1}\d[Z]{1}[A-Z\d]{1}$/',Rule::unique('users', 'dealer_gstin_no') ],
            'authorized_person_name' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
            'pin_code' => ['required', 'numeric', 'digits_between:6,6'],
            'state' => ['required', 'string', 'max:255'],
            'district' => ['required', 'string', 'max:255'],
            'landmark' => ['required', 'string', 'max:255'],
            // 'landline_no' => [ 'digits_between:8,12'],
            // 'mobile_no' => ['required', 'numeric', 'digits:10', Rule::unique('users', 'mobile')],
            'mobile_no' => ['required', 'numeric', 'digits:10'],
            // 'fax_no' => ['nullable', 'regex:/^[0-9]{0,10}$/'],
            'email_id' => ['required', 'email', Rule::unique('users', 'email')],
        ];
    }
    public function messages()
    {
        return [
            'dealer_name.required' => 'The dealer name is required.',
            'dealer_name.string' => 'The dealer name must be a string.',
            'dealer_name.max' => 'The dealer name must not exceed :max characters.',
            'dealer_code.required' => 'The dealer code is required.',
            // 'dealer_code.string' => 'The dealer code must be a string.',
            'dealer_code.max' => 'The dealer code must not exceed :max characters.',
            'gstin_number.required' => 'The GSTIN number is required.',
            'gstin_number.regex' => 'The GSTIN number format is invalid.',
            'authorized_person_name.required' => 'The authorized person name is required.',
            'authorized_person_name.string' => 'The authorized person name must be a string.',
            'authorized_person_name.max' => 'The authorized person name must not exceed :max characters.',
            'address.required' => 'The address is required.',
            'address.string' => 'The address must be a string.',
            'address.max' => 'The address must not exceed :max characters.',
            'pin_code.required' => 'The pin code is required.',
            'pin_code.string' => 'The pin code must be a string.',
            'pin_code.max' => 'The pin code must not exceed :max characters.',
            'state.required' => 'The state is required.',
            'state.string' => 'The state must be a string.',
            'state.max' => 'The state must not exceed :max characters.',
            'district.required' => 'The district is required.',
            'district.string' => 'The district must be a string.',
            'district.max' => 'The district must not exceed :max characters.',
            'landmark.required' => 'The landmark is required.',
            'landmark.string' => 'The landmark must be a string.',
            'landmark.max' => 'The landmark must not exceed :max characters.',
            // 'landline_no.required' => 'The landline number is required.',
            // 'landline_no.regex' => 'The landline number format is invalid.',
            // 'landline_no.unique' => 'The landline number has already been taken.',
            'mobile_no.required' => 'The mobile number is required.',
            'mobile_no.regex' => 'The mobile number format is invalid.',
            'mobile_no.unique' => 'The mobile number has already been taken.',
            'fax_no.regex' => 'The fax number format is invalid.',
            'email_id.required' => 'The email address is required.',
            'email_id.email' => 'The email address must be a valid email address.',
            'email_id.unique' => 'The email address has already been taken.',
            // Add similar custom error messages for other fields as needed...
        ];
    }
}
