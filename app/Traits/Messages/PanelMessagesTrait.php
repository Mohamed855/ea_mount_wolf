<?php

namespace App\Traits\Messages;

trait PanelMessagesTrait {
    public function adminMessages(): array
    {
        return [
            'name.required' => 'Name is required',
            'name.min' => 'Name must be between 2 and 20 characters',
            'name.max' => 'Name must be between 2 and 20 characters',

            'email.required' => 'Email is required',
            'email.email' => 'Enter a valid email',
            'email.unique' => 'This email is already exist',

            'password.required' => 'Password is required',
            'password.min' => 'Password must between 8 and 20',
            'password.max' => 'Password must between 8 and 20',
        ];
    }
    public function adminUpdateMessages(): array
    {
        return [
            'name.required' => 'Name is required',
            'name.min' => 'Name must be between 2 and 20 characters',
            'name.max' => 'Name must be between 2 and 20 characters',

            'email.required' => 'Email is required',
            'email.email' => 'Enter a valid email',
        ];
    }
    public function announcementMessages(): array
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
    public function filesMessages(): array
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
    public function lineMessages(): array
    {
        return [
            'name.required' => 'Line name is required',
            'name.min' => 'Line name must be between 3 and 50 characters',
            'name.max' => 'Line name must be between 3 and 50 characters',
        ];
    }
    public function sectorMessages(): array
    {
        return [
            'name.required' => 'Sector name is required',
            'name.min' => 'Sector name must be between 3 and 50 characters',
            'name.max' => 'Sector name must be between 3 and 50 characters',
        ];
    }
    public function topicMessages(): array
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
    public function userMessages(): array
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

            'sectors.required' => 'Sector is required',
            'title.required' => 'Title is required',
            'lines.required' => 'Line is required',

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
    public function updateUserMessages(): array
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

            'user_name.required' => 'User name is required',
            'user_name.min' => 'User name must be between 2 and 30 characters',
            'user_name.max' => 'User name must be between 2 and 30 characters',
            'user_name.unique' => 'User name is already exist',

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
    public function videosMessages(): array
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
