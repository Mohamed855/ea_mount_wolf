<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\AddUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index()
    {
        $users = DB::table('users')->select('first_name','middle_name','last_name','email', 'title', 'created_at')->get();
        return view('user.users')->with(['users' => $users]);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AddUserRequest $request)
    {
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
        $user->title = $data['title'];
        $user->line = $data['line'];
        $user->email = $data['email'];
        $user->phone_number = $data['phone_number'];
        $user->password = bcrypt($data['password']);

        $user->save();

        return  redirect()->route('home');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
