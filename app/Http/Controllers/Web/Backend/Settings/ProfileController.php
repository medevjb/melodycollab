<?php

namespace App\Http\Controllers\Web\Backend\Settings;

use Exception;
use App\Models\User;
use App\Helpers\Helper;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    /**
     * Display the profile settings page.
     *
     * @return View
     */
    public function showProfile()
    {
        return view('backend.layouts.settings.profile_settings');
    }

    /**
     * Update the user's profile information.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function UpdateProfile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:100|min:2',
            'email' => 'required|email|unique:users,email,' . auth()->user()->id,
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        try {
            $user = User::find(auth()->user()->id);
            $user->name = $request->name;
            $user->email = $request->email;

            $user->save();
            return redirect()->back()->with('t-success', 'Profile updated successfully');
        } catch (Exception $e) {
            return redirect()->back()->with('t-error', $e->getMessage());
        }
    }

    /**
     * Update the user's password.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function UpdatePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'old_password' => 'required',
            'password' => 'required|confirmed|min:8',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        try {
            $user = Auth::user();
            if (Hash::check($request->old_password, $user->password)) {
                $user->password = Hash::make($request->password);
                $user->save();

                return redirect()->back()->with('t-success', 'Password updated successfully');
            } else {
                return redirect()->back()->with('t-error', 'Current password is incorrect');
            }
        } catch (Exception) {
            return redirect()->back()->with('t-error', 'Something went wrong');
        }
    }

    /**
     * Update the user's profile picture.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function UpdateProfilePicture(Request $request)
    {
        Log::info('Update Profile Picture', ['input' => $request->all()]);
        try {
            $request->validate([
                'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,bmp|max:4048',
            ]);

            $userDetails = User::where('id', Auth::id())->first();

            if ($request->hasFile('profile_picture')) {
                $image = $request->file('profile_picture');
                $imageName = Helper::fileUpload($image, 'users', time());
                $userDetails->avatar = $imageName;
            }

            $userDetails->save();

            return response()->json([
                'success' => true,
                'image_url' => asset($userDetails->avatar),
            ]);
        } catch (Exception $e) {
            Log::error('An error occurred while uploading the profile picture.', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while uploading the profile picture.',
            ]);
        }
    }

    /**
     * Update the user's Cover Photo
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function UpdateCoverPicture(Request $request)
    {
        try {
            $request->validate([
                'cover' => 'nullable|image|mimes:jpeg,png,jpg|max:4048',
            ]);

            $userDetails = User::where('id', Auth::id())->first();

            if ($request->hasFile('cover')) {
                $image = $request->file('cover');
                $imageName = Helper::fileUpload($image, 'users', time());
                $userDetails->cover = $imageName;
            }

            $userDetails->save();

            return response()->json([
                'success' => true,
                'image_url' => asset($userDetails->cover),
            ]);
        } catch (Exception) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while uploading the profile picture.',
            ]);
        }
    }
}
