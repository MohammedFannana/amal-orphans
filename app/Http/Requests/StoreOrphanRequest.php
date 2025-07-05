<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreOrphanRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'image' => ['required' , 'image' , 'dimensions:min_width=100,min_height=100','max:1048576'],
            'name' => ['required' , 'string'],
            'role' => ['required' , 'in:candidate,auditor,rejected,certified,waiting,sponsored'],
            'association_id' => ['required' , 'exists:associations,id'],
            'birth_date' => ['required' , 'date'],
            'birth_place' => ['required' , 'string'],
            'country' => ['required' ,'string'],
            'city' => ['required' ,'string'],
            'landmark' => ['required' ,'string'],
            'id_number' => ['required' , 'numeric' , 'unique:orphans,id_number'],
            'orphan_status' => ['required' , 'in:يتيم الأم,يتيم الأب,يتيم الأبوين'],
            'gender' => ['required' , 'in:ذكر,أنثى'],


            'mother_name' => ['required' ,'string'],
            'death_mother_date' => ['nullable' ,'string' ,'required_if:orphan_status,يتيم الأبوين,يتيم الأم'],

            'cause_mother_death' => ['nullable' ,'string' ,'required_if:orphan_status,يتيم الأبوين,يتيم الأم'],

            'father_name' => ['required' ,'string'],

            'death_father_date' => ['nullable' ,'string' , 'required_if:orphan_status,يتيم الأبوين,يتيم الأب'],

            'cause_father_death' => ['nullable' ,'string' , 'required_if:orphan_status,يتيم الأبوين,يتيم الأب'],

            'mother_id_number' => ['nullable' ,'numeric' ,'required_if:orphan_status,يتيم الأب'],

            'mother_marital_status' => ['nullable' ,'string' , 'required_if:orphan_status,يتيم الأب'],

            'mother_phone' => ['nullable' ,'string' ,'required_if:orphan_status,يتيم الأب'],

            'father_id_number' => ['nullable' ,'numeric' ,'required_if:orphan_status,يتيم الأم'],

            'father_marital_status' => ['nullable' ,'string' ,'required_if:orphan_status,يتيم الأم'],

            'father_phone' => ['nullable' ,'string' , 'required_if:orphan_status,يتيم الأم'],

        //     'income' => ['required' ,'string'],
            'income_value' => ['nullable' ,'string' ,'required_if:income,دخل ثابت'],

            'income_source' => ['nullable' ,'string' , 'required_if:income,دخل ثابت'],

            'father_death_certificate' => ['nullable', 'image', 'dimensions:min_width=100,min_height=100', 'max:1048576', 'required_without:not_available_father_death'],
            'not_available_father_death' => ['nullable', 'string', 'required_without:father_death_certificate'],

            'mother_death_certificate' => ['nullable' ,'image' , 'dimensions:min_width=100,min_height=100','max:1048576' ,'required_without:not_available_mother_death'],
            'not_available_mother_death' => ['nullable' ,'string' ,'required_without:mother_death_certificate'],


        //     // //store in profiles table
        //     // // 'orphan_id' => ['required' , 'exists:profiles,id'],
            'guardian_name' => ['required' , 'string'],
            'guardian_relation' => ['required' , 'string'],
            'guardian_jop' => ['required' , 'string'],


            'guardian_id_number' => ['required' , 'numeric'],
            'guardian_housing' => ['required' , 'string'],
            'guardian_whats_phone' => ['required' , 'string'],
            'guardian_first_phone' => ['required' , 'string'],
            'guardian_secound_phone' => ['required' , 'string'],
            'guardian_email' => ['required' , 'email'],
            'health_status' => ['required' , 'in:جيد,مريض'],
            'disease_type' => ['nullable' , 'in:مرض عادي,مرض مزمن,مرض عضال' ,
                                'required_if:health_status,مريض'],

           'medical_report' => [
                'nullable','image','dimensions:min_width=100,min_height=100',
                'max:1048576','required_without:not_available_medical_report'
            ],

            'not_available_medical_report' => [
                'nullable','string','required_without:medical_report'
            ],

            'educational_status' => ['required' , 'in:دون سن الدراسة,يدرس,لا يدرس'],

            'academic_stage' => ['nullable' , 'string', 'required_if:educational_status,يدرس'],
            'average' => ['nullable' , 'string', 'required_if:educational_status,يدرس'],

            'educational_certificate' => ['nullable' , 'image' , 'dimensions:min_width=100,min_height=100','max:1048576',
                function ($attribute, $value, $fail) use ($request) {
                    // تحقق إذا كانت قيمة receive_guarantee هي "wallet"
                    if ($request->educational_status === 'يدرس') {
                        // إذا كانت الشهادة  فارغة وكان سبب عدم التوفر غير مملوء
                        if (empty($value) && empty($request->not_available_educational_certificate)) {
                            $fail('يجب تقديم الشهادة الدراسية  أو سبب عدم التوفر.');
                        }
                    }
                }
            ],

            'not_available_educational_certificate' => ['nullable' , 'string' ,
                function ($attribute, $value, $fail) use ($request) {
                    // تحقق إذا كانت قيمة receive_guarantee هي "wallet"
                    if ($request->educational_status === 'يدرس') {
                        // إذا كان سبب عدم التوفر فارغًا وكان صورة الشهادة غير مملوءة
                        if (empty($value) && empty($request->educational_certificate)) {
                            $fail('يجب تقديم صورة الشهادة الدراسية أو سبب عدم التوفر.');
                        }
                    }
                }
            ],

            'brother_name' => ['required', 'array'],
            'brother_name.*' => ['string', 'required'],

            'brother_gender' => ['required', 'array'],
            'brother_gender.*' => ['string', 'required', 'in:ذكر,أنثى'],

            'brother_age' => ['required', 'array'],
            'brother_age.*' => ['string', 'required'],

            'brother_marital_status' => ['required', 'array'],
            'brother_marital_status.*' => ['string', 'required'],

            'brother_jop' => ['required', 'array'],
            'brother_jop.*' => ['string', 'required'],

            'brother_id_number' => ['required', 'array'],
            'brother_id_number.*' => ['numeric', 'required', Rule::unique('siblings', 'brother_id_number')],


            // 'brother_name' => ['string' , 'required'],

            // 'brother_gender' => ['string' , 'required' ,'in:ذكر,أنثى,انثى'],

            // 'brother_age' => ['string' , 'required'],

            // 'brother_marital_status' => ['string' , 'required'],

            // 'brother_jop' => ['string' , 'required'],

            // 'brother_id_number' => ['numeric' , 'required' , Rule::unique('siblings', 'brother_id_number')],

            'receive_guarantee' => ['required' , 'in:bank,wallet'],

            'account_number' => ['nullable' , 'string' , 'required_if:receive_guarantee,bank'],

            'bank' => ['nullable' , 'string' , 'required_if:receive_guarantee,bank' ],

            'phone_number_linked_account' => ['nullable' , 'string' , 'required_if:receive_guarantee,bank'],

            'wallet_number' => ['nullable' , 'string' , 'required_if:receive_guarantee,wallet'],

            'wallet_owner' => ['nullable' , 'string' , 'required_if:receive_guarantee,wallet'],

            'wallet_owner_id_number' => ['nullable' , 'string' , 'required_if:receive_guarantee,wallet'],

            'wallet_owner_id_number_image' => [
                'nullable', 'image', 'dimensions:min_width=100,min_height=100', 'max:1048576',
                function ($attribute, $value, $fail) use ($request) {
                    // تحقق إذا كانت قيمة receive_guarantee هي "wallet"
                    if ($request->receive_guarantee === 'wallet') {
                        // إذا كانت صورة الهوية فارغة وكان سبب عدم التوفر غير مملوء
                        if (empty($value) && empty($request->not_available_wallet_owner_id_number_image)) {
                            $fail('يجب تقديم صورة الهوية أو سبب عدم التوفر.');
                        }
                    }
                }
            ],

        //     // تحقق من سبب عدم توفر صورة الهوية
            'not_available_wallet_owner_id_number_image' => [
                'nullable', 'string',
                function ($attribute, $value, $fail) use ($request) {
                    // تحقق إذا كانت قيمة receive_guarantee هي "wallet"
                    if ($request->receive_guarantee === 'wallet') {
                        // إذا كان سبب عدم التوفر فارغًا وكان صورة الهوية غير مملوءة
                        if (empty($value) && empty($request->wallet_owner_id_number_image)) {
                            $fail('يجب تقديم صورة الهوية أو سبب عدم التوفر.');
                        }
                    }
                }
            ],

        ];
    }
}
