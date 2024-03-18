<?php

namespace App\Traits\Messages;

trait PanelMessagesTrait {
    public function adminMessages(): array
    {
        return [
            'name.required' => 'Name is required',
            // 'name.min' => 'Name must be between 2 and 20 characters',
            // 'name.max' => 'Name must be between 2 and 20 characters',

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
            // 'name.min' => 'Name must be between 2 and 20 characters',
            // 'name.max' => 'Name must be between 2 and 20 characters',

            'email.required' => 'Email is required',
            'email.email' => 'Enter a valid email',
        ];
    }
    public function announcementMessages(): array
    {
        return [
            'title.required' => 'Announcement title is required',
            // 'title.min' => 'Announcement title must be between 2 and 20 characters',
            // 'title.max' => 'Announcement title must be between 2 and 20 characters',

            'image.required' => 'You must upload image',
            'image.max' => 'Image is too big',
            'image.mimes' => 'This type is not supported',
        ];
    }
    public function titleMessages(): array
    {
        return [
            'name.required' => 'Name is required',
            // 'name.min' => 'Name must be between 2 and 20 characters',
            // 'name.max' => 'Name must be between 2 and 20 characters',
        ];
    }
    public function filesMessages(): array
    {
        return [
            'name.required' => 'File name is required',
            // 'name.min' => 'File name must be between 2 and 20 characters',
            // 'name.max' => 'File name must be between 2 and 20 characters',

            'sector.not_in' => 'Please select Sector',
            'line.not_in' => 'Please select line',

            'file.required' => 'You must upload file',
            'file.max' => 'File is too big',
            'file.mimes' => 'This type is not supported',
        ];
    }
    public function lineMessages(): array
    {
        return [
            'name.required' => 'Line name is required',
            // 'name.min' => 'Line name must be between 2 and 20 characters',
            // 'name.max' => 'Line name must be between 2 and 20 characters',
        ];
    }
    public function sectorMessages(): array
    {
        return [
            'name.required' => 'Sector name is required',
            // 'name.min' => 'Sector name must be between 2 and 20 characters',
            // 'name.max' => 'Sector name must be between 2 and 20 characters',
        ];
    }
    public function topicMessages(): array
    {
        return [
            'title.required' => 'Topic title is required',
            // 'title.min' => 'Topic title must be between 2 and 20 characters',
            // 'title.max' => 'Topic title must be between 2 and 20 characters',

            'description.required' => 'Topic description is required',

            'image.required' => 'You must upload image',
            'image.max' => 'Image is too big',
            'image.mimes' => 'This type is not supported',
        ];
    }
    public function userMessages(): array
    {
        return [
            'first_name.required' => 'First name is required',
            // 'first_name.min' => 'First name must be between 2 and 20 characters',
            // 'first_name.max' => 'First name must be between 2 and 20 characters',

            'middle_name.required' => 'Middle name is required',
            // 'middle_name.min' => 'Middle name must be between 2 and 20 characters',
            // 'middle_name.max' => 'Middle name must be between 2 and 20 characters',

            'last_name.required' => 'Last name is required',
            // 'last_name.min' => 'Last name must be between 2 and 20 characters',
            // 'last_name.max' => 'Last name must be between 2 and 20 characters',

            'crm_code.required' => 'CRM code is required',
            'crm_code.unique' => 'CRM code is already exist',

            'title.required' => 'Title is required',

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
            // 'first_name.min' => 'First name must be between 2 and 20 characters',
            // 'first_name.max' => 'First name must be between 2 and 20 characters',

            'middle_name.required' => 'Middle name is required',
            // 'middle_name.min' => 'Middle name must be between 2 and 20 characters',
            // 'middle_name.max' => 'Middle name must be between 2 and 20 characters',

            'last_name.required' => 'Last name is required',
            // 'last_name.min' => 'Last name must be between 2 and 20 characters',
            // 'last_name.max' => 'Last name must be between 2 and 20 characters',

            'user_name.required' => 'User name is required',
            // 'user_name.min' => 'User name must be between 2 and 25 characters',
            // 'user_name.max' => 'User name must be between 2 and 25 characters',
            'user_name.unique' => 'User name is already exist',

            'crm_code.required' => 'CRM code is required',
            'crm_code.unique' => 'CRM code is already exist',

            'title.not_in' => 'Title is required',

            'email.required' => 'Email is required',
            'email.email' => 'Enter a valid email',
            'email.unique' => 'This email is already exist',

            'phone_number.required' => 'Phone number is required',
            'phone_number.unique' => 'This number is already exist',
            'phone_number.regex' => 'Enter a valid number',

        ];
    }
    public function videosMessages(): array
    {
        return [
            'name.required' => 'Video name is required',

            'video.required' => 'Video is required',
            'video.mimes' => 'Video type is not valid',
            'video.max' => 'Video is too big, max video size is 300 Mb',

            'sector.not_in' => 'Please select Sector',
            'line.not_in' => 'Please select line',
        ];
    }
    public function youtubeVideosMessages(): array
    {
        return [
            'name.required' => 'Video name is required',

            'youtube_link.required' => 'Youtube link is required',
            'youtube_link.regex' => 'Enter a valid youtube link',

            'sector.not_in' => 'Please select Sector',
            'line.not_in' => 'Please select line',
        ];
    }
    public function audiosMessages(): array
    {
        return [
            'name.required' => 'Audio name is required',

            'Audio.required' => 'Audio is required',
            'Audio.mimes' => 'Audio type is not valid',
            'Audio.max' => 'Audio is too big, max Audio size is 300 Mb',

            'sector.not_in' => 'Please select Sector',
            'line.not_in' => 'Please select line',
        ];
    }
}
