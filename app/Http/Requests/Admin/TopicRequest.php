<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class TopicRequest extends FormRequest
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
            'title' => 'required|min:3,|max:50',
            'description' => 'required',
            'image' => 'required|max:2048|mimetypes:image/jpeg,image/png,image/gif'
        ];
    }
    public function messages()
    {
        return [
            'title.required' => 'Topic title is required',
            'title.min' => 'Topic title must be between 3 and 50 characters',
            'title.max' => 'Topic title must be between 3 and 50 characters',

            'description.required' => 'Topic description is required',

            'image.required' => 'You must upload image',
            'image.max' => 'Image is too big',
            'image.mimetypes' => 'This type is not supported',

        ];
    }
}
