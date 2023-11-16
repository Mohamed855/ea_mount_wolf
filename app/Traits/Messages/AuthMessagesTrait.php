<?php

namespace App\Traits\Messages;

trait AuthMessagesTrait {
    public function adminLoginMessages(): array
    {
        return [
            'email' => 'required',
            'password' => 'required'
        ];
    }
    public function userLoginMessages(): array
    {
        return [
            'user_name.required' => 'Enter email or username ',
            'crm_code.required' => 'CRM code is required',
            'password.required' => 'Enter your password',
        ];
    }
    public function checkPasswordMessages(): array
    {
        return [
            'email.required' => 'Enter email or username ',
            'crm_code.required' => 'CRM code is required',
        ];
    }
}
