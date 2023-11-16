<?php

namespace App\Traits\Messages;

trait FrontMessagesTrait {
    public function updatePasswordMessages(): array
    {
        return [
            'old_password.required' => 'Old password is required',

            'new_password.required' => 'Password is required',
            'new_password.min' => 'Password must between 8 and 20',
            'new_password.max' => 'Password must between 8 and 20',
            'new_password.confirmed' => 'The password confirmation does not match',
        ];
    }
}
