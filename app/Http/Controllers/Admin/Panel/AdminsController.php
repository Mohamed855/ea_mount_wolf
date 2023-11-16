<?php

namespace App\Http\Controllers\Admin\Panel;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\AuthTrait;
use App\Traits\GeneralTrait;
use App\Traits\Messages\PanelMessagesTrait;
use App\Traits\Rules\PanelRulesTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use function Laravel\Prompts\select;

class AdminsController extends Controller
{
    use GeneralTrait;
    use AuthTrait;
    use PanelRulesTrait;
    use PanelMessagesTrait;

    public function index()
    {
        return $this->ifAdmin('admin.panel.admins.index', [
            'admins' => DB::table('users')->where('role', 1)
            ->select('id', 'first_name', 'email', 'profile_image', 'activated', 'created_at')
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (auth()->id() == 1) {
            return $this->ifAdmin('admin.panel.admins.create');
        }
        return back();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (auth()->id() == 1) {
            try {
                $admin = new User();
                $data = $request->all();

                $validator = Validator::make($data, $this->adminRules(), $this->adminMessages());

                if ($validator->fails()) {
                    return $this->backWithMessage('error', $validator->errors()->first());
                }

                $name = strtolower($data['name']);
                $code = $name . rand(1, 9);

                $i = 0;
                while (User::whereuser_name($code)->exists() || User::wherecrm_code($code)->exists() || User::wherephone_number($code)->exists()) {
                    $i++;
                    $code .= $i;
                }

                $admin->first_name = $data['name'];
                $admin->middle_name = $data['name'];
                $admin->last_name =  $data['name'];
                $admin->user_name = $code;
                $admin->crm_code = $code;
                $admin->email = $data['email'];
                $admin->phone_number = $code;
                $admin->password = bcrypt($data['password']);
                $admin->title_id = 0;
                $admin->lines = 0;
                $admin->sectors = 0;
                $admin->role = 1;
                $admin->activated = 1;

                $admin->save();

                return $this->backWithMessage('success', 'Admin added successfully');
            } catch (\Exception $e) {
                return $this->backWithMessage('error', 'Something went error, please try again later');
            }
        }
        return back();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        if (auth()->id() == 1 || auth()->id() == $id) {
            return $this->ifAdmin('admin.panel.admins.edit', [
                'selected_admin' => DB::table('users')->where('id', '=', $id)->
                select('id', 'first_name', 'email')->first(),
            ]);
        }
        return back();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if (auth()->id() == 1 || auth()->id() == $id) {
            try {
                $validator = Validator::make($request->all(), $this->adminUpdateRules($id), $this->adminUpdateMessages());

                if ($validator->fails()) {
                    return $this->backWithMessage('error', $validator->errors()->first());
                }

                $name = strtolower($request->name);
                $code = $name . rand(1, 9);

                $i = 0;
                while (User::whereuser_name($code)->exists() || User::wherecrm_code($code)->exists() || User::wherephone_number($code)->exists()) {
                    $i++;
                    $code .= $i;
                }

                DB::table('users')
                    ->where('id', '=', $id)
                    ->update([
                        'first_name' => $request->name,
                        'middle_name' => $request->name,
                        'last_name' => $request->name,
                        'user_name' => $code,
                        'crm_code' => $code,
                        'email' => $request->email,
                        'phone_number' => $code,
                        'title_id' => 0,
                        'lines' => 0,
                        'sectors' => 0,
                        'role'=> 1,
                        'activated' => 1,
                    ]);

                return $this->backWithMessage('success', 'Admin details saved successfully');
            } catch (\Exception $e) {
                return $this->backWithMessage('error', 'Something went error, please try again later');
            }
        }
        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (auth()->id() == 1) {
            $this->deleteFromDB('users', $id, 'storage/images/profile_images/', 'profile_image');
            return $this->backWithMessage('success', 'Admin has been deleted');
        }
        return back();
    }
}
