<?php

namespace App\Traits;

use Illuminate\Support\Facades\DB;

trait GeneralTrait {
    public function successView ($view) {
        return view($view);
    }
    public function redirect ($route) {
        return redirect()->route($route);
    }
    public function backWithMessage ($key, $value) {
        return redirect()->back()->with($key, $value);
    }
    public function deleteFromDB ($table, $id, $public_directory, $column_name) {
        $required_file_name = DB::table($table)->where('id', '=', $id)->first();
        if($public_directory !== null && $column_name !== null) {
            if ($required_file_name->$column_name !== null && file_exists(public_path($public_directory . $required_file_name->$column_name))) {
                unlink(public_path($public_directory . $required_file_name->$column_name));
            }
        }
        DB::table($table)->where('id', $id)->delete();
    }
}
