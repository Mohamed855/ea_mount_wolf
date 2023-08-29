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
            'password' => 'required'
        ];
    }
    public function messages()
    {
        return [
            'user_name.required' => 'Enter email or username ',
            'crm_code.required' => 'CRM code is required',
            'password.required' => 'Enter your password',
        ];
    }
}
