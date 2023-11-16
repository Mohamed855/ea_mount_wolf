<?php

namespace App\Http\Controllers\Admin\Panel;

use App\Http\Controllers\Controller;
use App\Models\Sector;
use App\Models\User;
use App\Traits\AuthTrait;
use App\Traits\GeneralTrait;
use App\Traits\Messages\PanelMessagesTrait;
use App\Traits\Rules\PanelRulesTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
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
            'employees' => DB::table('users as employees')
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
                'employees.sectors',
                'employees.lines',
                'employees.profile_image',
                'employees.activated',
                'employees.created_at',
                'titles.name as title_name',
            ),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return $this->ifAdmin('admin.panel.employees.create', [
                'sectors' => DB::table('sectors')->select(['id', 'name'])->get(),
                'lines' => DB::table('lines')->where('status', 1)->select(['id', 'name'])->get(),
                'titles' => DB::table('titles')->select(['id', 'name'])->get(),
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
            $middleName = strtolower($data['middle_name']);
            $username = $firstName . rand(1, 9);

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
            $employee->lines = $data['lines'];
            $employee->sectors = $data['sectors'];
            $employee->role = 3;
            $employee->activated = 1;

            $employee->save();

            return $this->backWithMessage('success', 'Employee Added Successfully');
        } catch (\Exception $e) {
            return $this->backWithMessage('error', 'Something went error, please try again later');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $selected_employee = DB::table('users')->where('id', '=', $id)->first();
        $sectors = DB::table('sectors')->select(['id', 'name'])->get();
        $lines = DB::table('lines')->where('status', 1)->select(['id', 'name'])->get();
        $titles = DB::table('titles')->select(['id', 'name'])->get();

        $decodedLines = json_decode($selected_employee->lines, true);
        $decodedSectors = json_decode($selected_employee->sectors, true);

        $integerSectorIds = array_map('intval', $decodedSectors);
        $integerLineIds = array_map('intval', $decodedLines);

        return $this->ifAdmin('admin.panel.employees.edit', [
            'selected_employee' => $selected_employee,
            'sectors' => $sectors,
            'lines' => $lines,
            'titles' => $titles,
            'integerSectorIds' => $integerSectorIds,
            'integerLineIds' => $integerLineIds,
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
                    'lines' => $request->lines,
                    'sectors' => $request->sectors,
                    'role' => 3,
                    'activated' => 1,
                ]);

            return $this->backWithMessage('success', 'Employee Details saved successfully');
        } catch (\Exception $e) {
            return $this->backWithMessage('error', 'Something went error, please try again later');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->deleteFromDB('users', $id, 'storage/images/profile_images/', 'profile_image');
        return $this->backWithMessage('success', 'Employee has been deleted');
    }
}
