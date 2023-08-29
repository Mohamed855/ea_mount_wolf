<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class LinesRequest extends FormRequest
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
            'name.required' => 'Line name is required',
            'name.min' => 'Line name must be between 3 and 50 characters',
            'name.max' => 'Line name must be between 3 and 50 characters',
        ];
    }
}
