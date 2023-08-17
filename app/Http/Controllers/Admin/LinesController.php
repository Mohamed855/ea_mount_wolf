<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;

class LinesController extends Controller
{
    use GeneralTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->ifAuthorized(
            $this->ifAuthenticated('site.lines.index')
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return $this->ifAuthorized(
            $this->ifAuthenticated('site.lines.create')
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
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
        $this->deleteFromDB('lines', $id, null, null);
        return $this->backWithMessage('deletedSuccessfully', 'Line has been deleted');
    }
}
