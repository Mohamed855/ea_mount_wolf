<?php

namespace App\Http\Controllers\Admin\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateUserRequest;
use App\Http\Requests\Admin\UserRequest;
use App\Models\User;
use App\Traits\AuthTrait;
use App\Traits\GeneralTrait;
use Illuminate\Support\Facades\DB;

class AdminsController extends Controller
{
    use GeneralTrait;
    use AuthTrait;

    public function index()
    {
        return $this->ifAdmin('admin.panel.admins.index', [
                    'admins' => DB::table('users as admins')
                    ->join('sectors', 'admins.sector_id', '=', 'sectors.id')
                    ->join('lines', 'admins.line_id', '=', 'lines.id')
                    ->join('titles', 'admins.title_id', '=', 'titles.id')
                    ->where('role', 1)
                    ->select(
                        'admins.id',
                        'admins.first_name',
                        'admins.middle_name',
                        'admins.last_name',
                        'admins.user_name',
                        'admins.email',
                        'admins.phone_number',
                        'admins.profile_image',
                        'admins.activated',
                        'admins.created_at',
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
        return $this->ifAdmin('admin.panel.admins.create', [
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
        $admin = new User();
        $data = $request->all();

        $firstName = strtolower($data['first_name']);
        $middleName = strtolower($data['middle_name']);
        $username = $firstName . $middleName . rand(1, 9);

        $i = 0;
        while (User::whereuser_name($username)->exists()) {
            $i++;
            $username .= $i;
        }

        $admin->first_name = $data['first_name'];
        $admin->middle_name = $data['middle_name'];
        $admin->last_name =  $data['last_name'];
        $admin->user_name = $username;
        $admin->crm_code = $data['crm_code'];
        $admin->email = $data['email'];
        $admin->phone_number = $data['phone_number'];
        $admin->password = bcrypt($data['password']);
        $admin->title_id = $data['title'];
        $admin->line_id = $data['line'];
        $admin->sector_id = $data['sector'];
        $admin->role = 1;
        $admin->activated = 1;

        $admin->save();

        return $this->backWithMessage('uploadedSuccessfully', 'Admin Added Successfully');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return $this->ifAdmin('admin.panel.admins.edit', [
                'selected_admin' => DB::table('users')->where('id', '=', $id)->first(),
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
                'role'=> 1,
                'activated' => 1,
            ]);

        return $this->backWithMessage('savedSuccessfully', 'Admin Details saved successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->deleteFromDB('users', $id, 'images/profile_images/', 'profile_image');
        return $this->backWithMessage('deletedSuccessfully', 'Admin has been deleted');
    }
}
