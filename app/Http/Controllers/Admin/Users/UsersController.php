<?php

namespace App\Http\Controllers\Admin\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateUserRequest;
use App\Http\Requests\Admin\UserRequest;
use App\Models\User;
use App\Traits\AuthTrait;
use App\Traits\GeneralTrait;
use Illuminate\Support\Facades\DB;

class UsersController extends Controller
{
    use GeneralTrait;
    use AuthTrait;

    public function index()
    {
        return $this->ifAdmin('admin.dashboard.users.index', [
                    'users' => DB::table('users')
                    ->join('sectors', 'users.sector_id', '=', 'sectors.id')
                    ->join('lines', 'users.line_id', '=', 'lines.id')
                    ->join('titles', 'users.title_id', '=', 'titles.id')
                    ->select(
                        'users.id',
                        'users.first_name',
                        'users.middle_name',
                        'users.last_name',
                        'users.user_name',
                        'users.email',
                        'users.phone_number',
                        'users.profile_image',
                        'users.activated',
                        'users.created_at',
                        'sectors.name as sector_name',
                        'lines.name as line_name',
                        'titles.name as title_name',
                    )
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return $this->ifAdmin('admin.dashboard.users.create', [
                'sectors' => DB::table('sectors')->select(['id', 'name'])->get(),
                'lines' => DB::table('lines')->select(['id', 'name'])->get(),
                'titles' => DB::table('titles')->select(['id', 'name'])->get(),
            ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
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
        $user->activated = 1;

        $user->save();

        return $this->backWithMessage('uploadedSuccessfully', 'User Added Successfully');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return $this->ifAdmin('admin.dashboard.users.edit', [
                'selected_user' => DB::table('users')->where('id', '=', $id)->first(),
                'sectors' => DB::table('sectors')->select(['id', 'name'])->get(),
                'lines' => DB::table('lines')->select(['id', 'name'])->get(),
                'titles' => DB::table('titles')->select(['id', 'name'])->get(),
            ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, string $id)
    {
        DB::table('users')
            ->where('id', '=', $id)
            ->update([
                'first_name' => $request->first_name,
                'middle_name' => $request->middle_name,
                'last_name' => $request->last_name,
                'user_name' => $request->user_name,
                'crm_code' => $request->crm_code,
                'email' => $request->email,
                'phone_number' => $request->phone_number,
                'title_id' => $request->title,
                'line_id' => $request->line,
                'sector_id' => $request->sector,
                'role'=> 2,
                'activated' => 1,
            ]);

        return $this->backWithMessage('savedSuccessfully', 'User Details saved successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->deleteFromDB('users', $id, 'images/profile_images/', 'profile_image');
        return $this->backWithMessage('deletedSuccessfully', 'User has been deleted');
    }
}
