<?php

namespace App\Traits\Rules;

use Illuminate\Validation\Rule;

trait PanelRulesTrait {

    public function adminRules(): array
    {
        return [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password'  => 'required|min:8|max:20|string',
        ];
    }
    public function adminUpdateRules($id): array
    {
        return [
            'name' => 'required',
            'email' => ['required', 'email', Rule::unique('users', 'email')->where(function ($query) use ($id) {
                $query->where('id', '!=', $id);
            })],
        ];
    }
    public function announcementRules(): array
    {
        return [
            'title' => 'required',
            'image' => 'required|max:20480|mimetypes:image/jpeg,image/png,image/gif'
        ];
    }
    public function titleRules(): array
    {
        return [
            'name' => 'required',
        ];
    }
    public function filesRules(): array
    {
        return [
            'name' => 'required',
            'file' => 'required|max:20480',
        ];
    }
    public function lineRules(): array
    {
        return [
            'name' => 'required',
        ];
    }
    public function sectorsRules(): array
    {
        return [
            'name' => 'required',
        ];
    }
    public function topicRules(): array
    {
        return [
            'title' => 'required',
            'description' => 'required',
            'image' => 'required|max:20480|mimetypes:image/jpeg,image/png,image/gif'
        ];
    }
    public function userRules(): array
    {
        return [
            'first_name' => 'required',
            'middle_name' => 'required',
            'last_name' => 'required',
            'crm_code' => 'required|unique:users',
            'title' => 'required',
            'email' => 'required|email|unique:users',
            'phone_number' => 'required|regex:/(01)[0-9]{9}/|unique:users',
            'password'  => 'required|min:8|max:20|string',
        ];
    }
    public function updateUserRules($id): array
    {
        return [
            'first_name' => 'required',
            'middle_name' => 'required',
            'last_name' => 'required',
            'user_name' => ['required', Rule::unique('users', 'user_name')->where(function ($query) use ($id) {
                $query->where('id', '!=', $id);
            })],
            'crm_code' => ['required', Rule::unique('users', 'crm_code')->where(function ($query) use ($id) {
                $query->where('id', '!=', $id);
            })],
            'title' => 'not_in:0',
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
            'video' => 'required|max:307200',
            'name' => 'required',
        ];
    }
    public function audiosRules(): array
    {
        return [
            'audio' => 'required|max:307200',
            'name' => 'required',
        ];
    }
}
