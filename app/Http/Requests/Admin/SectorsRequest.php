<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class SectorsRequest extends FormRequest
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
            'name' => 'required|min:3|max:50',
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'Sector name is required',
            'name.min' => 'Sector name must be between 3 and 50 characters',
            'name.max' => 'Sector name must be between 3 and 50 characters',
        ];
    }
}
