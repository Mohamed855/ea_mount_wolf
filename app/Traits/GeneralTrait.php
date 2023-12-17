<?php

namespace App\Traits;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

trait GeneralTrait {
    public function backWithMessage ($key, $value): RedirectResponse
    {
        return redirect()->back()->with($key, $value);
    }
    public function deleteFromDB ($table, $id, $public_directory, $column_name): void
    {
        $required_file_name = DB::table($table)->where('id', '=', $id)->first();
        if($public_directory !== null && $column_name !== null) {
            if ($required_file_name->$column_name !== null && Storage::exists('public/' . $public_directory . $required_file_name->$column_name)) {
                Storage::delete('public/' . $public_directory . $required_file_name->$column_name);
            }
        }
        DB::table($table)->where('id', $id)->delete();
    }
}
