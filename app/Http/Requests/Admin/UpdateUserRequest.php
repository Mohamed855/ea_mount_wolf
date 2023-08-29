<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
            'phone_number' => 'required|regex:/(01)[0-9]{9}/|unique:users',
            'password'  => 'required|min:8|max:20|string',
        ];
    }
    public function messages()
    {
        return [
            'first_name.required' => 'First name is required',
            'first_name.min' => 'First name must be between 2 and 20 characters',
            'first_name.max' => 'First name must be between 2 and 20 characters',

            'middle_name.required' => 'Middle name is required',
            'middle_name.min' => 'Middle name must be between 2 and 20 characters',
            'middle_name.max' => 'Middle name must be between 2 and 20 characters',

            'last_name.required' => 'Last name is required',
            'last_name.min' => 'Last name must be between 2 and 20 characters',
            'last_name.max' => 'Last name must be between 2 and 20 characters',

            'crm_code.required' => 'CRM code is required',
            'crm_code.unique' => 'CRM code is already exist',

            'sector.not_in' => 'Sector is required',
            'title.not_in' => 'Title is required',
            'line.not_in' => 'Line is required',

            'email.required' => 'Email is required',
            'email.email' => 'Enter a valid email',
            'email.unique' => 'This email is already exist',

            'phone_number.required' => 'Phone number is required',
            'phone_number.unique' => 'This number is already exist',
            'phone_number.regex' => 'Enter a valid number',

            'password.required' => 'Password is required',
            'password.min' => 'Password must between 8 and 20',
            'password.max' => 'Password must between 8 and 20',

        ];
    }
}
