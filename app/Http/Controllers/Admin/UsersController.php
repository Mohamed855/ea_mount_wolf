<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UsersController extends Controller
{
    use GeneralTrait;
    public function index()
    {
        return $this->ifAuthorized(
            $this->ifAuthenticated('site.users.index')
                ->with('users', DB::table('users')
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
                        'users.profile_image',
                        'users.activated',
                        'users.created_at',
                        'sectors.name as sector_name',
                        'lines.name as line_name',
                        'titles.name as title_name',
                    )->get()
                )
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return $this->ifAuthorized(
            $this->ifAuthenticated('site.users.create')
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RegisterRequest $request)
    {
        //
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
        $this->deleteFromDB('users', $id, 'images/profile_images/', 'profile_image');
        return $this->backWithMessage('deletedSuccessfully', 'User has been deleted');
    }
}
