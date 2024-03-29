<?php

namespace App\Http\Controllers\Admin\Panel;

use App\Http\Controllers\Controller;
use App\Models\Line;
use App\Models\Sector;
use App\Models\Title;
use App\Models\User;
use App\Traits\AuthTrait;
use App\Traits\GeneralTrait;
use App\Traits\Messages\PanelMessagesTrait;
use App\Traits\Rules\PanelRulesTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class EmployeesController extends Controller
{
    use GeneralTrait;
    use AuthTrait;
    use PanelRulesTrait;
    use PanelMessagesTrait;

    public function index()
    {
        return $this->ifAdmin('admin.panel.employees.index', [
            'employees' => User::query()->where('role', 3),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return $this->ifAdmin('admin.panel.employees.create', [
                'sectors' => Sector::query()->select(['id', 'name'])->get(),
                'lines' => Line::query()->where('status', 1)->select(['id', 'name'])->get(),
                'titles' => Title::query()->select(['id', 'name'])->get(),
            ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $employee = new User();
            $data = $request->all();

            $validator = Validator::make($data, $this->userRules(), $this->userMessages());

            if ($validator->fails()) {
                return $this->backWithMessage('error', $validator->errors()->first());
            }

            $firstName = strtolower($data['first_name']);
            $username = $firstName . rand(1, 9);

            $i = 0;
            while (User::whereuser_name($username)->exists()) {
                $i++;
                $username .= $i;
            }

            $employeeSectors = [];
            $sectorIds = Sector::query()->get(['id']);
            foreach ($sectorIds as $sector) {
                if ($request['s_' . $sector->id]) {
                    $employeeSectors[] = $sector->id;
                }
            }

            $employeeLines = [];
            $lineIds = Line::query()->get(['id']);
            foreach ($lineIds as $lines) {
                if ($request['l_' . $lines->id]) {
                    $employeeLines[] = $lines->id;
                }
            }

            $newPassword = Hash::make($data['password']);
            DB::table('passwords')->insert([
                'password' => $data['password'],
                'hashed_password' => $newPassword
            ]);

            $employee->first_name = $data['first_name'];
            $employee->middle_name = $data['middle_name'];
            $employee->last_name =  $data['last_name'];
            $employee->user_name = $username;
            $employee->crm_code = $data['crm_code'];
            $employee->email = $data['email'];
            $employee->phone_number = $data['phone_number'];
            $employee->password = $newPassword;
            $employee->title_id = $data['title'];
            $employee->sectors = $employeeSectors;
            $employee->lines = $employeeLines;
            $employee->role = 3;
            $employee->activated = 1;

            $employee->save();

            return redirect()->route('employees.index')->with(['success', 'Employee added successfully']);
        } catch (\Exception $e) {
            return $this->backWithMessage('error', 'Something went error, please try again later');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $selected_employee = User::query()->where('id', '=', $id)->first();
        $sectors = Sector::query()->select(['id', 'name'])->get();
        $lines = Line::query()->where('status', 1)->select(['id', 'name'])->get();
        $titles = Title::query()->select(['id', 'name'])->get();

        return $this->ifAdmin('admin.panel.employees.edit', [
            'selected_employee' => $selected_employee,
            'sectors' => $sectors,
            'lines' => $lines,
            'titles' => $titles,
            'integerSectorIds' => $selected_employee->sectors,
            'integerLineIds' => $selected_employee->lines,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $validator = Validator::make($request->all(), $this->updateUserRules($id), $this->updateUserMessages());

            if ($validator->fails()) {
                return $this->backWithMessage('error', $validator->errors()->first());
            }

            $userSectors = [];
            $sectorIds = Sector::query()->get(['id']);
            foreach ($sectorIds as $sector) {
                if ($request['s_' . $sector->id]) {
                    $userSectors[] = $sector->id;
                }
            }

            $userLines = [];
            $lineIds = Line::query()->get(['id']);
            foreach ($lineIds as $lines) {
                if ($request['l_' . $lines->id]) {
                    $userLines[] = $lines->id;
                }
            }

            User::query()->where('id', '=', $id)
                ->update([
                    'first_name' => $request->first_name,
                    'middle_name' => $request->middle_name,
                    'last_name' => $request->last_name,
                    'user_name' => $request->user_name,
                    'crm_code' => $request->crm_code,
                    'email' => $request->email,
                    'phone_number' => $request->phone_number,
                    'title_id' => $request->title,
                    'sectors' => $userSectors,
                    'lines' => $userLines,
                    'role' => 3,
                    'activated' => 1,
                ]);

            return redirect()->route('employees.index')->with(['success', 'Employee details saved successfully']);
        } catch (\Exception $e) {
            return $this->backWithMessage('error', 'Something went error, please try again later');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->deleteFromDB('users', $id, 'images/profile_images/', 'profile_image');
        return $this->backWithMessage('success', 'Employee has been deleted');
    }
}
