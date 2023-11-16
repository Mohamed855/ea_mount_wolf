<?php

namespace App\Traits\Rules;

use Illuminate\Validation\Rule;

trait PanelRulesTrait {

    public function adminRules(): array
    {
        return [
            'name' => 'required|min:2,|max:20',
            'email' => 'required|email|unique:users',
            'password'  => 'required|min:8|max:20|string',
        ];
    }
    public function adminUpdateRules($id): array
    {
        return [
            'name' => 'required|min:2,|max:20',
            'email' => ['required', 'email', Rule::unique('users', 'email')->where(function ($query) use ($id) {
                $query->where('id', '!=', $id);
            })],
        ];
    }
    public function announcementRules(): array
    {
        return [
            'title' => 'required|min:3,|max:50',
            'image' => 'required|max:10240|mimetypes:image/jpeg,image/png,image/gif'
        ];
    }
    public function filesRules(): array
    {
        return [
            'name' => 'required|min:3,|max:50',
            'sector' => 'not_in:0',
            'line' => 'not_in:0',
            'file' => 'required|max:10240|mimetypes:application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/vnd.oasis.opendocument.text,text/plain,application/pdf,application/zip,application/x-rar-compressed,application/x-7z-compressed,application/x-tar,application/gzip,image/jpeg,image/png,image/gif,image/bmp,image/tiff,image/svg+xml'
        ];
    }
    public function lineRules(): array
    {
        return [
            'name' => 'required|min:3|max:50',
        ];
    }
    public function sectorsRules(): array
    {
        return [
            'name' => 'required|min:3|max:50',
        ];
    }
    public function topicRules(): array
    {
        return [
            'title' => 'required|min:3,|max:50',
            'description' => 'required',
            'image' => 'required|max:2048|mimetypes:image/jpeg,image/png,image/gif'
        ];
    }
    public function userRules(): array
    {
        return [
            'first_name' => 'required|min:2,|max:20',
            'middle_name' => 'required|min:2,|max:20',
            'last_name' => 'required|min:2,|max:20',
            'crm_code' => 'required|unique:users',
            'title' => 'required',
            'sectors' => 'required',
            'lines' => 'required',
            'email' => 'required|email|unique:users',
            'phone_number' => 'required|regex:/(01)[0-9]{9}/|unique:users',
            'password'  => 'required|min:8|max:20|string',
        ];
    }
    public function updateUserRules($id): array
    {
        return [
            'first_name' => 'required|min:2,|max:20',
            'middle_name' => 'required|min:2,|max:20',
            'last_name' => 'required|min:2,|max:20',
            'user_name' => ['required', 'min:2', 'max:30', Rule::unique('users', 'user_name')->where(function ($query) use ($id) {
                $query->where('id', '!=', $id);
            })],
            'crm_code' => ['required', Rule::unique('users', 'crm_code')->where(function ($query) use ($id) {
                $query->where('id', '!=', $id);
            })],
            'sector' => 'not_in:0',
            'title' => 'not_in:0',
            'line' => 'not_in:0',
            'email' => ['required', 'email', Rule::unique('users', 'email')->where(function ($query) use ($id) {
                $query->where('id', '!=', $id);
            })],
            'phone_number' => ['required', 'regex:/(01)[0-9]{9}/', Rule::unique('users', 'phone_number')->where(function ($query) use ($id) {
                $query->where('id', '!=', $id);
            })],
        ];
    }
    public function videosRules(): array
    {
        return [
            'name' => 'required|min:3,|max:50',
            'src' => 'required|regex:/https:\/\/www\.youtube\.com\/watch\?v=[^&]+/',
            'sector' => 'not_in:0',
            'line' => 'not_in:0',
        ];
    }
}
