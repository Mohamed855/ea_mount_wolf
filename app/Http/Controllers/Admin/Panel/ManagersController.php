<?php

namespace App\Http\Controllers\Admin\Panel;

use App\Http\Controllers\Controller;
use App\Models\Line;
use App\Models\ManagerLines;
use App\Models\Sector;
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
            $manager->sectors = [];
            $manager->lines = [];
            $manager->role = 2;
            $manager->activated = 1;

            $manager->save();

            $manager = User::query()->where('role', 2)->latest('id')->first();
            $managerSectors = [];
            $sectorIds = Sector::query()->get(['id']);
            $lineIds = Line::query()->get(['id']);

            foreach ($sectorIds as $sector) {
                if ($request['s_' . $sector->id]) {
                    $managerSectors[] = $sector->id;
                    $managerSectorLines = [];
                    foreach ($lineIds as $line) {
                        if ($request['s_' . $sector->id . 'l_' . $line->id]) {
                            $managerSectorLines[] = $line->id;
                        }
                    }
                    $manager_lines = new ManagerLines();
                    $manager_lines->user_id = $manager->id;
                    $manager_lines->sector_id = $sector->id;
                    $manager_lines->lines = $managerSectorLines;
                    $manager_lines->save();
                    unset($managerSectorLines);
                }
            }
            $manager->update(['sectors' => $managerSectors]);

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
        $titles = DB::table('titles')->select(['id', 'name'])->get();

        $decodedSectors = json_decode($selected_manager->sectors, true);

        return $this->ifAdmin('admin.panel.managers.edit', [
            'selected_manager' => $selected_manager,
            'sectors' => $sectors,
            'titles' => $titles,
            'integerSectorIds' => $decodedSectors,
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

            ManagerLines::query()->where('user_id', $id)->delete();

            $managerSectors = [];
            $sectorIds = Sector::query()->get(['id']);
            $lineIds = Line::query()->get(['id']);

            foreach ($sectorIds as $sector) {
                if ($request['s_' . $sector->id]) {
                    $managerSectors[] = $sector->id;
                    $managerSectorLines = [];
                    foreach ($lineIds as $line) {
                        if ($request['s_' . $sector->id . 'l_' . $line->id]) {
                            $managerSectorLines[] = $line->id;
                        }
                    }
                    $manager_lines = new ManagerLines();
                    $manager_lines->user_id = $id;
                    $manager_lines->sector_id = $sector->id;
                    $manager_lines->lines = $managerSectorLines;
                    $manager_lines->save();
                    unset($managerSectorLines);
                }
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
                    'sectors' => $managerSectors,
                    'lines' => [],
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
        ManagerLines::query()->where('user_id', $id)->delete();
        return $this->backWithMessage('success', 'Manager has been deleted');
    }
}
