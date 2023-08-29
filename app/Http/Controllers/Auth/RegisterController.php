<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\RegistrationNotification;
use App\Models\User;
use App\Notifications\ActivationEmail;
use App\Traits\GeneralTrait;
use App\Traits\AuthTrait;
use Illuminate\Support\Facades\DB;

class RegisterController extends Controller
{
    use GeneralTrait;
    use AuthTrait;

    public function sign_up()
    {
        $sectors = DB::table('sectors')->select(['id', 'name'])->get();
        $lines = DB::table('lines')->select(['id', 'name'])->get();
        $titles = DB::table('titles')->select(['id', 'name'])->get();
        return $this->ifNotAuthenticated(
            view('auth.sign_up')->with([
            'sectors' => $sectors,
            'lines' => $lines,
            'titles' => $titles,
            ])
        );
    }

    public function register(RegisterRequest $request) {
        $user = new User();
        $data = $request->all();

        $firstName = strtolower($data['first_name']);
        $middleName = strtolower($data['middle_name']);
        $username = $firstName . $middleName . rand(1, 9);

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

        /*$getUser = User::find($username);
        $getUser->notify(new ActivationEmail());*/

        $sector_name = DB::table('sectors')->select('name')->where('id', $data['sector'])->first();
        $line_name = DB::table('lines')->select('name')->where('id', $data['line'])->first();

        $notification = new RegistrationNotification;

        $notification->text = 'There is a registration request in sector (' . $sector_name->name . ') - line (' . $line_name->name . ')';
        $notification->sector_id = $data['sector'];
        $notification->line_id = $data['line'];

        $notification->save();

        return  $this->redirect('login')->with('activeRequest', 'Your activation request has been sent, check your email for approval');
    }
}
