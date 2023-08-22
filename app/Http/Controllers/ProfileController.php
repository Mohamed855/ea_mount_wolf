<?php

namespace App\Http\Controllers;

use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


class ProfileController extends Controller
{
    use GeneralTrait;

    public function profile($user_name) {
        $me = DB::table('users')->where('user_name', '=', $user_name)->first();
        return $this->ifAuthenticated('site.user.profile')->with('me', $me);
    }
    public function change_password()
    {
        return $this->ifAuthenticated('site.user.change_password');
    }
    public function update_password(Request $request)
    {
        $user = Auth::user();

        if (Hash::check($request->old_password, $user->password)) {
            $user->password = Hash::make($request->new_password);
            $user->save();

            return $this->backWithMessage('changedSuccessfully', 'Password changed successfully');
        } else {
            return $this->backWithMessage('incorrect', 'Incorrect Password');
        }
    }
    public function update_profile_picture(Request $request)
    {
        if ($request->hasFile('profile_picture')) {
            $profile_picture = $request->file('profile_picture');
            $filename = time() . '.' . $profile_picture->getClientOriginalExtension();
            $profile_picture->move(public_path('images/profile_images'), $filename);
            DB::table('users')
                ->where('id', '=', auth()->user()->id)
                ->update([
                    'profile_image' => $filename,
                ]);
        }
        return $this->backWithMessage('changedSuccessfully', 'Profile picture changed successfully');
    }
    public function delete_profile_picture()
    {
        $public_user_profile_image ='images/profile_images/' . auth()->user()->profile_image;
        if (file_exists(public_path($public_user_profile_image))) {
            unlink(public_path($public_user_profile_image));
        }
        DB::table('users')
            ->where('id', '=', auth()->user()->id)
            ->update([
                'profile_image' => null,
            ]);
        return $this->backWithMessage('deletedSuccessfully', 'Profile picture deleted successfully');
    }
}
