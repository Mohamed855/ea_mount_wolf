<?php

namespace App\Traits\Rules;

trait FrontRulesTrait {
    public function profilePictureRules(): array
    {
        return [
            'profile_picture' => 'required'
        ];
    }
    public function updatePasswordRules(): array
    {
        return [
            'old_password' => 'required',
            'new_password' => 'required|min:8|max:20|string|confirmed',
        ];
    }
    public function commentRules(): array
    {
        return [
            'comment' => 'required'
        ];
    }
}
