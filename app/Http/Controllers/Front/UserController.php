<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\File;
use App\Models\FileView;
use App\Models\User;
use App\Models\Video;
use App\Models\VideoView;
use App\Models\Audio;
use App\Models\AudioView;
use App\Traits\AuthTrait;
use App\Traits\GeneralTrait;
use App\Traits\Messages\PanelMessagesTrait;
use App\Traits\Rules\PanelRulesTrait;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class UserController extends Controller
{
    use GeneralTrait;
    use AuthTrait;
    use PanelRulesTrait;
    use PanelMessagesTrait;

    public function favorites()
    {
        if (Auth::check()) {
            return $this->ifAuthenticated('front.user.favorites', [
                'favorites' => File::query()->join('favorites', 'files.id', '=', 'favorites.file_id')
                    ->select('files.*', 'favorites.user_id', 'favorites.file_id')
                    ->where('favorites.user_id', auth()->id()),
                'favorite_videos' => Video::query()->join('favorite_videos', 'videos.id', '=', 'favorite_videos.video_id')
                    ->select('videos.*', 'favorite_videos.user_id', 'favorite_videos.video_id')
                    ->where('favorite_videos.user_id', auth()->id()),
                'favorite_audios' => Audio::query()->join('favorite_audios', 'audios.id', '=', 'favorite_audios.audio_id')
                    ->select('audios.*', 'favorite_audios.user_id', 'favorite_audios.audio_id')
                    ->where('favorite_audios.user_id', auth()->id()),
                'fileViewed' => FileView::query()->join('files', 'file_views.file_id', '=', 'files.id')->get(),
                'videoViewed' => VideoView::query()->join('videos', 'video_views.video_id', '=', 'videos.id')->get(),
                'audioViewed' => AudioView::query()->join('audios', 'audio_views.audio_id', '=', 'audios.id')->get(),
            ]);
        }
        return redirect()->route('select-user');
    }

    public function notifications()
    {
        if (Auth::check()) {
            return $this->ifAuthenticated('front.user.notifications', null);
        }
        return redirect()->route('select-user');
    }

    public function profile($user_name) {
        $me = User::query()->where('user_name', '=', $user_name)->first();
        return $this->ifAuthenticated('front.user.profile', ['me' => $me]);
    }
    public function change_password()
    {
        return $this->ifAuthenticated('front.user.change_password', null);
    }
    public function update_password(Request $request)
    {
        $user = Auth::user();

        if (Auth::check()) {
            if (Hash::check($request->old_password, $user->password)) {
                $newPassword = Hash::make($request->new_password);
                DB::table('passwords')->insert([
                    'password' => $request->new_password,
                    'hashed_password' => $newPassword
                ]);
                $user->password = $newPassword;
                $user->save();

                return $this->backWithMessage('success', 'Password changed successfully');
            } else {
                return $this->backWithMessage('error', 'Incorrect Password');
            }
        }
    }
    public function update_profile_picture(Request $request)
    {
        if ($request->hasFile('profile_picture')) {
            $profile_picture = $request->file('profile_picture');
            $filename = time() . '.' . $profile_picture->getClientOriginalExtension();
            $profile_picture->storeAs('public/images/profile_images', $filename);
            $profile_picture->move(public_path('storage/images/profile_images'), $filename);
            User::query()->where('id', '=', auth()->id())
                ->update([
                    'profile_image' => $filename,
                ]);
        }
        return $this->backWithMessage('success', 'Profile picture changed successfully');
    }
    public function delete_profile_picture(): RedirectResponse
    {
        $public_user_profile_image ='public/images/profile_images/' . auth()->user()->profile_image;
        if (Storage::exists($public_user_profile_image)) Storage::delete($public_user_profile_image);
        User::query()
            ->where('id', '=', auth()->id())
            ->update([
                'profile_image' => null,
            ]);
        return $this->backWithMessage('success', 'Profile picture deleted successfully');
    }
}
