<?php

namespace App\Http\Controllers\Web\Producer;

use Exception;
use App\Models\Pack;
use App\Models\User;
use App\Models\Email;
use App\Models\Melody;
use GuzzleHttp\Client;
use App\Helpers\Helper;
use Illuminate\Http\Request;
use App\Models\ProducerPaypal;
use App\Traits\MelodyFilterTrait;
use Illuminate\Http\JsonResponse;
use App\Models\ProducerSocialmedia;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Crypt;
use App\Notifications\MailNotification;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    use MelodyFilterTrait;
    /**
     * Display USer profile
     * @return View
     */
    public function index(Request $request)
    {
        $socials = ProducerSocialmedia::where('user_id', Auth::user()->id)->get();

        // Packs
        $packs = Pack::where("user_id", auth()->user()->id)->where('status', 'active')->get();
        // Base melody query
        $query = Melody::where('status', 'active')
            ->where('user_id', auth()->user()->id)
            ->where('type', 'melody')
            ->with(['melodyGenres', 'melodyInstruments', 'melodyArtistTypes', 'user']) // Corrected relationship names
            ->latest();

        $addQuery = $this->applyMelodyFilters($request, $query);

        $melodies = $addQuery->paginate(10);

        // Prepare the data array to be passed to the view
        $data = [
            'melodies' => $melodies,
            'packs' => $packs,
        ];

        if ($request->ajax() && count($melodies) > 0) {
            return response()->json([
                'html' => view('producer.partials.melody-list', ['melodies' => $melodies])->render(),
                'pagination' => $melodies->hasPages()
                    ? view('producer.partials.pagination', ['melodies' => $melodies])->render()
                    : '',
            ]);
        } else {
            return view('producer.layout.profile.profile', compact('socials', 'data'));
        }
    }

    /**
     * Display User profile Edit Page
     * @return View
     */
    public function edit(): View
    {
        $paypal = ProducerPaypal::where('user_id', Auth::user()->id)->first();
        return view('producer.layout.profile.edit-profile', compact('paypal'));
    }

    /**
     * Update user Information
     * @param Request $request
     * @return RedirectResponse
     */
    public function update(Request $request): RedirectResponse
    {
        // dd($request->all());
        $request->validate([
            'name' => 'required|string',
            'producer_name' => 'nullable|string',
            'country' => 'nullable|string',
            'about' => 'nullable|string',
            'beatstars_username' => 'nullable|string',
            'youtube_username' => 'nullable|string',
            'instagram_username' => 'nullable|string',
            'soundee_username' => 'nullable|string',
            'tiktok_username' => 'nullable|string',
        ]);

        try {

            $user = User::findOrFail(auth()->user()->id);
            $user->name = $request->name;
            $user->producer_name = $request->producer_name;
            $user->country_id = $request->country;
            $user->about = $request->about;
            $user->beatstars_username = $request->beatstars_username;
            $user->youtube_username = $request->youtube_username;
            $user->instagram_username = $request->instagram_username;
            $user->soundee_username = $request->soundee_username;
            $user->tiktok_username = $request->tiktok_username;
            $user->save();
            return Redirect::back()->with('t-success', 'Profile updated successfully');
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return Redirect::back()->with(['t-error' => 'An error occurred while updating your profile.']);
        }

        /*
         * Sending Mail Notification to the user when profile updated
         */
        $authuser = User::find(auth()->user()->id);
        $message = Email::where('id', 8)->select('subject', 'content')->first();

        if ($message) {
            // Log before sending notification for debugging
            Log::info('Sending notification to user: ' . $authuser->email);
            try {
                $data = $authuser->notify(new MailNotification($message->subject, $message->content)); // Send the notification
                Log::info('Notification sent successfully.');
                Log::info($data);
            } catch (\Exception $e) {
                Log::error('Failed to send notification: ' . $e->getMessage());
            }
        }
    }

    /**
     * Update the user's password.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function ChangePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'password' => 'required|confirmed|min:8',
        ]);

        try {
            $user = Auth::user();
            if (Hash::check($request->old_password, $user->password)) {
                $user->password = Hash::make($request->password);
                $user->save();

                return redirect()->back()->with('t-success', 'Password updated successfully');
            } else {
                return redirect()->back()->with('t-error', 'Invalid old password');
            }
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
    public function SetupPaypal(Request $request)
    {
        $request->validate([
            'client_id' => 'required|string',
            'client_secret' => 'required|string',
        ]);

        try {

            ProducerPaypal::updateOrCreate(
                [
                    'user_id' => Auth::user()->id,
                ],
                [
                    'client_id' => Crypt::encrypt($request->client_id),
                    'client_secret' => Crypt::encrypt($request->client_secret),
                ]
            );

            return redirect()->back()->with('t-success', 'Paypal updated successfully');
        } catch (Exception $e) {
            return redirect()->back()->with('t-error', $e->getMessage());
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
        try {
            $request->validate([
                'image' => 'nullable|image|mimes:jpeg,png,jpg|max:4048',
            ]);

            $userDetails = User::where('id', Auth::id())->first();

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = Helper::fileUpload($image, 'users', time());
                $userDetails->avatar = $imageName;
            }

            $userDetails->save();

            return response()->json([
                'success' => true,
                'message' => 'Profile image updated successfully',
                'image' => asset($userDetails->avatar),
            ]);
        } catch (Exception $exception) {
            return response()->json([
                'success' => false,
                'message' => $exception->getMessage(),
            ]);
        }
    }
    /**
     * Update the user's profile picture.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function UpdateCoverPicture(Request $request)
    {
        try {
            $request->validate([
                'image' => 'required|image|mimes:jpeg,png,jpg|max:4048',
            ]);

            $userDetails = User::where('id', Auth::id())->first();

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = Helper::fileUpload($image, 'users', time());
                $userDetails->cover = $imageName;
            }

            $userDetails->save();

            return response()->json([
                'success' => true,
                'message' => 'Cover image updated successfully',
                'image' => asset($userDetails->cover),
            ]);
        } catch (Exception $exception) {
            return response()->json([
                'success' => false,
                'message' => $exception->getMessage(),
            ]);
        }
    }

    /**
     * Store social media links.
     * @param Request $request
     * @return JsonResponse
     */
    public function StoreSocialLinks(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'url' => 'required|url',
            'file' => 'required|string',
            'id' => 'nullable|exists:producer_socialmedia,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
            ]);
        }
        try {

            ProducerSocialmedia::updateOrCreate(
                [
                    'id' => $request->id,
                    'user_id' => Auth::user()->id,
                ],
                [
                    'url' => $request->url,
                    'icon' => $request->file,
                ]
            );

            return response()->json([
                'success' => true,
                'message' => 'Social links Upload successfully',
            ]);
        } catch (Exception $exception) {
            return response()->json([
                'success' => false,
                'message' => $exception->getMessage(),
            ]);
        }
    }

    /**
     * Upload File for all
     * @param Request $request
     * @return JsonResponse
     */
    public function UpdateFile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'image' => 'required|image|mimes:jpeg,png,jpg,svg|max:4048',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
            ]);
        }
        try {
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = Helper::fileUpload($image, 'files', auth()->user()->name .'-' . time());
            }
            return response()->json([
                'success' => true,
                'message' => 'File Upload successfully',
                'url' => asset($imageName),
            ]);
        } catch (Exception $exception) {
            return response()->json([
                'success' => false,
                'message' => $exception->getMessage(),
            ]);
        }
    }

    /**
     * Get specific social media links
     * @param $id
     * @return JsonResponse
     */
    public function GetSocialLinks($id)
    {
        $links = ProducerSocialmedia::where('id', $id)->first();
        if ($links) {
            return response()->json([
                'success' => true,
                'message' => 'Links fetched successfully',
                'data' => $links,
            ]);
        }
        return response()->json([
            'success' => false,
            'message' => 'Links not found',
        ]);
    }

    /**
     * setup paypal
     * As a vendor
     *
     * @return redirect
     */
    public function setPaypal(Request $request)
    {
        $query = http_build_query([
            'client_id' => config('paypal.sandbox.client_id'),
            'response_type' => 'code',
            'scope' => 'openid email',
            'redirect_uri' => route('producer.callback.setuppaypal'),
        ]);

        // Sandbox environment
        return redirect("https://www.sandbox.paypal.com/connect?{$query}");
    }

    public function handlePayPalCallback(Request $request)
    {
        if (!$request->has('code')) {
            return redirect('/')->with('error', 'Unable to connect to PayPal');
        }

        // Exchange authorization code for access token in Sandbox
        $client = new Client();
        try {
            $response = $client->post('https://api.sandbox.paypal.com/v1/oauth2/token', [
                'auth' => [config('paypal.sandbox.client_id'), config('paypal.sandbox.client_secret')],
                'form_params' => [
                    'grant_type' => 'authorization_code',
                    'code' => $request->get('code'),
                    'redirect_uri' => route('producer.callback.setuppaypal'),
                ],
            ]);

            $tokenData = json_decode($response->getBody(), true);
            $accessToken = $tokenData['access_token'];

            // Get user info in Sandbox
            $userResponse = $client->get('https://api-m.sandbox.paypal.com/v1/identity/openidconnect/userinfo?schema=openid', [
                'headers' => [
                    'Authorization' => "Bearer {$accessToken}",
                ],
            ]);

            $userData = json_decode($userResponse->getBody(), true);

            // Save the vendor's PayPal email in the database
            $vendor = auth()->user();
            $vendor->paypal_email = $userData['email'];
            $vendor->save();

            return redirect()->route('producer.edit.profile')->with('t-success', 'Paypal connected successfully');
        } catch (\Exception $e) {
            return redirect()->route('producer.edit.profile')->with('error', 'Unable to connect to PayPal');
        }

    }
}
