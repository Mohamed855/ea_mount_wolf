<?php

namespace App\Traits\Rules;

trait AuthRulesTrait {
    public function adminLoginRules(): array
    {
        return [
            'email' => 'required',
            'password' => 'required'
        ];
    }
    public function userLoginRules(): array
    {
        return [
            'user_name' => 'required',
            'crm_code' => 'required',
            'password' => 'required'
        ];
    }
    public function checkPasswordRules(): array
    {
        return [
            'email' => 'required',
            'crm_code' => 'required',
        ];
    }
}
