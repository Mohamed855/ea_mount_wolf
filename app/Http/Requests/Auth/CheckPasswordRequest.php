<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class CheckPasswordRequest extends FormRequest
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
            'email' => 'required',
            'crm_code' => 'required',
        ];
    }
    public function messages()
    {
        return [
            'email.required' => 'Enter email or username ',
            'crm_code.required' => 'CRM code is required',
        ];
    }
}
