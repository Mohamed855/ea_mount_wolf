<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class AnnouncementsRequest extends FormRequest
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
            'image' => 'required|max:10240|mimetypes:image/jpeg,image/png,image/gif'
        ];
    }
    public function messages()
    {
        return [
            'title.required' => 'Announcement title is required',
            'title.min' => 'Announcement title must be between 3 and 50 characters',
            'title.max' => 'Announcement title must be between 3 and 50 characters',

            'image.required' => 'You must upload image',
            'image.max' => 'Image is too big',
            'image.mimetypes' => 'This type is not supported',

        ];
    }
}
