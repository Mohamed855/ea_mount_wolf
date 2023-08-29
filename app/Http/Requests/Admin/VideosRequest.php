<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class VideosRequest extends FormRequest
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
            'name' => 'required|min:3,|max:50',
            'src' => 'required|regex:/https:\/\/www\.youtube\.com\/watch\?v=[^&]+/',
            'sector' => 'not_in:0',
            'line' => 'not_in:0',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Video name is required',
            'name.min' => 'Video name must be between 3 and 50 characters',
            'name.max' => 'Video name must be between 3 and 50 characters',

            'src.required' => 'Youtube link is required',
            'src.regex' => 'Enter a valid youtube link',

            'sector.not_in' => 'Please select Sector',
            'line.not_in' => 'Please select line',

        ];
    }
}
