<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'first_name' => 'required|min:2,|max:20',
            'middle_name' => 'required|min:2,|max:20',
            'last_name' => 'required|min:2,|max:20',
            'crm_code' => 'required|unique:users',
            'sector' => 'not_in:0',
            'title' => 'not_in:0',
            'line' => 'not_in:0',
            'email' => 'required|email|unique:users',
            'phone_number' => 'required|min:11|max:11|unique:users',
            'password'  => 'required|min:8|string|confirmed',
        ];
    }
    public function messages()
    {
        return [
            'first_name.required' => 'الاسم الاول مطلوب ',
            'first_name.min' => 'يجب ان يكون الاسم الاول اكثر من 2 حروف ',
            'first_name.max' => 'يجب ان يكون الاسم الاول اقل من 20 حرف ',

            'middle_name.required' => 'الاسم الاوسط مطلوب ',
            'middle_name.min' => 'يجب ان يكون الاسم الاوسط اكثر من 2 حروف ',
            'middle_name.max' => 'يجب ان يكون الاسم الاوسط اقل من 20 حرف ',

            'last_name.required' => 'اسم الاخير  مطلوب ',
            'last_name.min' => 'يجب ان يكون الاسم الاخير اكثر من 3 حروف ',
            'last_name.max' => 'يجب ان يكون الاسم الاخير اقل من 20 حرف ',

            'crm_code.required' => 'يرجي ادخال كود CRM',
            'crm_code.unique' => 'كود CRM مسجل من قبل',

            'sector.not_in' => 'يرجي ادخال القسم',
            'title.not_in' => ' يرجي ادخال الوظيفة',
            'line.not_in' => 'يرجي ادخال خط الانتاج',

            'email.required' => 'يرجي ادخال البريد الإلكتروني',
            'email.email' => 'رجاء إدخال عنوان بريد إلكتروني صحيح',
            'email.unique' => 'البريد الإلكتروني مسجل من قبل',

            'phone_number.required' => 'يرجي كتابة رقم الموبايل',
            'phone_number.unique' => 'رقم الهاتف مسجل من قبل',
            'phone_number.min' => 'يجب ان يتكون رقم الموبايل من 11 رقم',
            'phone_number.max' => 'يجب ان يتكون رقم الموبايل من 11 رقم',

            'password.required' => 'يرجي كتابة كلمة المرور و يجب ان تكون اكبر من 8 حروف',
            'password.min' => 'يجب ان تكون كلمة المرور اكبر من 8 حروف',
            'password.confirmed' => 'تأكيد كلمة المرور غير متطابق.',

        ];
    }
}
