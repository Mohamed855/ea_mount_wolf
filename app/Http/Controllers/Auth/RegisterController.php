<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use App\Traits\GeneralTrait;

class RegisterController extends Controller
{
    use GeneralTrait;

    public function sign_up()
    {
        return $this->ifNotAuthenticated(
            $this->selectorData('auth.sign_up')
        );
    }

    public function register(RegisterRequest $request) {
        $user = new User();
        $data = $request->all();

        $firstName = strtolower($data['first_name']);
        $lastName = strtolower($data['last_name']);
        $username = $firstName . $lastName . rand(1, 9);

        $i = 0;
        while (User::whereuser_name($username)->exists()) {
            $i++;
            $username .= $i;
        }

        $user->first_name = $data['first_name'];
        $user->middle_name = $data['middle_name'];
        $user->last_name =  $data['last_name'];
        $user->user_name = $username;
        $user->crm_code = $data['crm_code'];
        $user->email = $data['email'];
        $user->phone_number = $data['phone_number'];
        $user->password = bcrypt($data['password']);
        $user->title_id = $data['title'];
        $user->line_id = $data['line'];
        $user->sector_id = $data['sector'];

        $user->save();

        return  $this->redirectWithMessage(
            'login',
            'activeRequest',
            'Your activation request has been sent, check your email for approval'
        );
    }
}
