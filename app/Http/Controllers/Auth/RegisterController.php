<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\Email;
use App\Helpers\Helper;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Notifications\MailNotification;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default, this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
     */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = 'producer/my-profile';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'producer_name' => ['required', 'string', 'max:255'],
            'country' => ['required', 'string', 'max:255'],
            'beatstars_username' => ['nullable', 'string', 'max:255'],
            'instragram_username' => ['nullable', 'string', 'max:255'],
            'soundee_username' => ['nullable', 'string', 'max:255'],
            'youtube_username' => ['nullable', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     */
    protected function create(array $data)
    {

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'username' => Str::slug($data['name']),
            'password' => Hash::make($data['password']),
            'producer_name' => $data['producer_name'],
            'country_id' => $data['country'],
            'beatstars_username' => $data['beatstars_username'] ?? null,
            'instagram_username' => $data['instragram_username'] ?? null,
            'soundee_username' => $data['soundee_username'] ?? null,
            'avatar' => "https://i.ibb.co.com/7JV97d8/blank-profile-picture-973460-1280.png",
        ]);

        $messages = Email::whereIn('id', [1, 2])->select('subject', 'content')->get();

        if ($messages->count() === 2) {
            Log::info('Sending email notifications to ' . $user->email);
            try {
                $user->notify(new MailNotification($messages[0]->subject, $messages[0]->content));
                $user->notify(new MailNotification($messages[1]->subject, $messages[1]->content));
                Log::info('Email notifications sent to ' . $user->email);
            } catch (\Exception $e) {
                Log::error('Failed to send email notifications to ' . $user->email . ': ' . $e->getMessage());
            }
        }
        return $user; // Return the created user
    }
}
