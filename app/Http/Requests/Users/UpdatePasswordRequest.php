<?php

namespace App\Http\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdatePasswordRequest extends FormRequest
{
    public function authorize()
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'old_password' => 'required',
            'new_password' => 'required|min:8|max:20|string|confirmed',
        ];
    }

    public function messages()
    {
        return [
            'old_password.required' => 'Old password is required',

            'new_password.required' => 'Password is required',
            'new_password.min' => 'Password must between 8 and 20',
            'new_password.max' => 'Password must between 8 and 20',
            'new_password.confirmed' => 'The password confirmation does not match',

        ];
    }
}
