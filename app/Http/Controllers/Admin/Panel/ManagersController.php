<?php

namespace App\Http\Controllers\Admin\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateUserRequest;
use App\Http\Requests\Admin\UserRequest;
use App\Models\User;
use App\Traits\AuthTrait;
use App\Traits\GeneralTrait;
use Illuminate\Support\Facades\DB;

class ManagersController extends Controller
{
    use GeneralTrait;
    use AuthTrait;

    public function index()
    {
        return $this->ifAdmin('admin.panel.managers.index', [
                    'managers' => DB::table('users as managers')
                    ->join('sectors', 'managers.sector_id', '=', 'sectors.id')
                    ->join('lines', 'managers.line_id', '=', 'lines.id')
                    ->join('titles', 'managers.title_id', '=', 'titles.id')
                    ->where('role', 2)
                    ->select(
                        'managers.id',
                        'managers.first_name',
                        'managers.middle_name',
                        'managers.last_name',
                        'managers.user_name',
                        'managers.email',
                        'managers.phone_number',
                        'managers.profile_image',
                        'managers.activated',
                        'managers.created_at',
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
        return $this->ifAdmin('admin.panel.managers.create', [
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
        $manager = new User();
        $data = $request->all();

        $firstName = strtolower($data['first_name']);
        $middleName = strtolower($data['middle_name']);
        $username = $firstName . $middleName . rand(1, 9);

        $i = 0;
        while (User::whereuser_name($username)->exists()) {
            $i++;
            $username .= $i;
        }

        $manager->first_name = $data['first_name'];
        $manager->middle_name = $data['middle_name'];
        $manager->last_name =  $data['last_name'];
        $manager->user_name = $username;
        $manager->crm_code = $data['crm_code'];
        $manager->email = $data['email'];
        $manager->phone_number = $data['phone_number'];
        $manager->password = bcrypt($data['password']);
        $manager->title_id = $data['title'];
        $manager->line_id = $data['line'];
        $manager->sector_id = $data['sector'];
        $manager->role = 2;
        $manager->activated = 1;

        $manager->save();

        return $this->backWithMessage('uploadedSuccessfully', 'Manager Added Successfully');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return $this->ifAdmin('admin.panel.managers.edit', [
                'selected_manager' => DB::table('users')->where('id', '=', $id)->first(),
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

        return $this->backWithMessage('savedSuccessfully', 'Manager Details saved successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->deleteFromDB('users', $id, '../public/images/profile_images/', 'profile_image');
        return $this->backWithMessage('deletedSuccessfully', 'Manager has been deleted');
    }
}
