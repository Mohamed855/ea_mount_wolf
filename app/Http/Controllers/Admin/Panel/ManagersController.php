<?php

namespace App\Http\Controllers\Admin\Panel;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\AuthTrait;
use App\Traits\GeneralTrait;
use App\Traits\Messages\PanelMessagesTrait;
use App\Traits\Rules\PanelRulesTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ManagersController extends Controller
{
    use GeneralTrait;
    use AuthTrait;
    use PanelRulesTrait;
    use PanelMessagesTrait;

    public function index()
    {
        return $this->ifAdmin('admin.panel.managers.index', [
                    'managers' => DB::table('users as managers')
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
                        'managers.sectors',
                        'managers.lines',
                        'managers.activated',
                        'managers.created_at',
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
            $manager = new User();
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

            $manager->first_name = $data['first_name'];
            $manager->middle_name = $data['middle_name'];
            $manager->last_name = $data['last_name'];
            $manager->user_name = $username;
            $manager->crm_code = $data['crm_code'];
            $manager->email = $data['email'];
            $manager->phone_number = $data['phone_number'];
            $manager->password = bcrypt($data['password']);
            $manager->title_id = $data['title'];
            $manager->lines = $data['lines'];
            $manager->sectors = $data['sectors'];
            $manager->role = 2;
            $manager->activated = 1;

            $manager->save();

            return $this->backWithMessage('success', 'Manager added successfully');
        } catch (\Exception $e) {
            return $this->backWithMessage('error', 'Something went error, please try again later');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $selected_manager = DB::table('users')->where('id', '=', $id)->first();
        $sectors = DB::table('sectors')->select(['id', 'name'])->get();
        $lines = DB::table('lines')->where('status', 1)->select(['id', 'name'])->get();
        $titles = DB::table('titles')->select(['id', 'name'])->get();

        $decodedLines = json_decode($selected_manager->lines, true);
        $decodedSectors = json_decode($selected_manager->sectors, true);

        $integerSectorIds = array_map('intval', $decodedSectors);
        $integerLineIds = array_map('intval', $decodedLines);

        return $this->ifAdmin('admin.panel.managers.edit', [
            'selected_manager' => $selected_manager,
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
                    'role' => 2,
                    'activated' => 1,
                ]);

            return $this->backWithMessage('success', 'Manager details saved successfully');
        }  catch (\Exception $e) {
            return $this->backWithMessage('error', 'Something went error, please try again later');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->deleteFromDB('users', $id, 'storage/images/profile_images/', 'profile_image');
        return $this->backWithMessage('success', 'Manager has been deleted');
    }
}
