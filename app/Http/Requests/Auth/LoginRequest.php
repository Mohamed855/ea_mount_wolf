<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
            'user_name' => 'required',
            'crm_code' => 'required',
            'password'  => 'required|min:8|string',
        ];
    }
    public function messages()
    {
        return [
            'user_name.required' => 'ادخل اسم المستخدم او البريد الألكترونى ',
            'crm_code.required' => 'كود CRM مطلوب',
            'password.required' => 'يرجي كتابة كلمة المرور و يجب ان تكون اكبر من 8 حروف',
        ];
    }
}
