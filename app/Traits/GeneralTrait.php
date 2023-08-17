<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

trait GeneralTrait {
    public function selectorData ($view) {
        $sectors = DB::table('sectors')->select(['id', 'name'])->get();
        $lines = DB::table('lines')->select(['id', 'name'])->get();
        $titles = DB::table('titles')->select(['id', 'name'])->get();
        return view($view)->with([
            'sectors' => $sectors,
            'lines' => $lines,
            'titles' => $titles,
        ]);
    }
    public function ifAuthenticated ($view) {
        if(Auth::check()) {
            $current_user = auth()->user()->id;
            $user_details = DB::table('users')
                ->join('titles', 'users.title_id', '=', 'titles.id')
                ->join('lines', 'users.line_id', '=', 'lines.id')
                ->join('sectors', 'users.sector_id', '=', 'sectors.id')
                ->select('users.user_name',
                    'users.profile_image',
                    'titles.name as title_name',
                    'lines.name as line_name',
                    'sectors.name as sector_name')
                ->where('users.id', $current_user)
                ->first();
            return $this->successViewWithMessage($view, 'user_details', $user_details);
        }
        return $this->redirect('login');
    }
    public function ifAuthorized ($return) {
        if(Auth::check()) {
            if (auth()->user()->sector_id == 1) {
                return $return;
            }
            return $this->redirect('login');
        }
        return $this->redirect('not_authorized');
    }
    public function ifNotAuthenticated ($return) {
        if (!Auth::check())
            return $return;
        return $this->redirect('home');
    }
    public function successView ($view) {
        return view($view);
    }
    public function successViewWithMessage ($view, $key, $value) {
        return view($view)->with($key, $value);
    }
    public function redirect ($route) {
        return redirect()->route($route);
    }
    public function redirectWithMessage ($route, $key, $value) {
        return redirect()->route($route)->with($key, $value);
    }
    public function back () {
        return redirect()->back();
    }
    public function backWithMessage ($key, $value) {
        return redirect()->back()->with($key, $value);
    }
    public function deleteFromDB ($table, $id, $public_directory, $column_name) {
        $required_file_name = DB::table($table)->where('id', '=', $id)->first();
        if($public_directory !== null && $column_name !== null)
            unlink(public_path($public_directory . $required_file_name->$column_name));
        DB::table($table)->where('id', $id)->delete();
    }
}
