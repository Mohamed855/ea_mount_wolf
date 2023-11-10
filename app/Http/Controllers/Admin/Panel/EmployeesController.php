<?php

namespace App\Http\Controllers\Admin\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateUserRequest;
use App\Http\Requests\Admin\UserRequest;
use App\Models\User;
use App\Traits\AuthTrait;
use App\Traits\GeneralTrait;
use Illuminate\Support\Facades\DB;

class EmployeesController extends Controller
{
    use GeneralTrait;
    use AuthTrait;

    public function index()
    {
        return $this->ifAdmin('admin.panel.employees.index', [
                    'employees' => DB::table('users as employees')
                    ->join('sectors', 'employees.sector_id', '=', 'sectors.id')
                    ->join('lines', 'employees.line_id', '=', 'lines.id')
                    ->join('titles', 'employees.title_id', '=', 'titles.id')
                    ->where('role', 3)
                    ->select(
                        'employees.id',
                        'employees.first_name',
                        'employees.middle_name',
                        'employees.last_name',
                        'employees.user_name',
                        'employees.email',
                        'employees.phone_number',
                        'employees.profile_image',
                        'employees.activated',
                        'employees.created_at',
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
        return $this->ifAdmin('admin.panel.employees.create', [
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
        $employee = new User();
        $data = $request->all();

        $firstName = strtolower($data['first_name']);
        $middleName = strtolower($data['middle_name']);
        $username = $firstName . $middleName . rand(1, 9);

        $i = 0;
        while (User::whereuser_name($username)->exists()) {
            $i++;
            $username .= $i;
        }

        $employee->first_name = $data['first_name'];
        $employee->middle_name = $data['middle_name'];
        $employee->last_name =  $data['last_name'];
        $employee->user_name = $username;
        $employee->crm_code = $data['crm_code'];
        $employee->email = $data['email'];
        $employee->phone_number = $data['phone_number'];
        $employee->password = bcrypt($data['password']);
        $employee->title_id = $data['title'];
        $employee->line_id = $data['line'];
        $employee->sector_id = $data['sector'];
        $employee->role = 3;
        $employee->activated = 1;

        $employee->save();

        return $this->backWithMessage('uploadedSuccessfully', 'Employee Added Successfully');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return $this->ifAdmin('admin.panel.employees.edit', [
                'selected_employee' => DB::table('users')->where('id', '=', $id)->first(),
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
                'role'=> 3,
                'activated' => 1,
            ]);

        return $this->backWithMessage('savedSuccessfully', 'Employee Details saved successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->deleteFromDB('users', $id, 'storage/images/profile_images/', 'profile_image');
        return $this->backWithMessage('deletedSuccessfully', 'Employee has been deleted');
    }
}
