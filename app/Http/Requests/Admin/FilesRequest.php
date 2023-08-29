<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class FilesRequest extends FormRequest
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
            'name' => 'required|min:3,|max:50',
            'sector' => 'not_in:0',
            'line' => 'not_in:0',
            'file' => 'required|max:10240|mimetypes:application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/vnd.oasis.opendocument.text,text/plain,application/pdf,application/zip,application/x-rar-compressed,application/x-7z-compressed,application/x-tar,application/gzip,image/jpeg,image/png,image/gif,image/bmp,image/tiff,image/svg+xml'
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'File name is required',
            'name.min' => 'File name must be between 3 and 50 characters',
            'name.max' => 'File name must be between 3 and 50 characters',

            'sector.not_in' => 'Please select Sector',
            'line.not_in' => 'Please select line',

            'file.required' => 'You must upload file',
            'file.max' => 'File is too big',
            'file.mimetypes' => 'This type is not supported',

        ];
    }
}
