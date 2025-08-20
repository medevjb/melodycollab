<?php

namespace App\Http\Controllers\Web\Frontend;

use App\Models\Pack;
use App\Models\User;
use App\Jobs\ProcessEmail;
use App\Models\DynamicPage;
use Illuminate\Http\Request;
use App\Models\SystemSetting;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Validated;
use App\Notifications\ContactFormNotification;

class HomeController extends Controller
{
    /**
     * Show Landing page
     * @return View
     */
    public function index()
    {
        $packs = Pack::orderBy('created_at', 'desc')->with('user', 'melodies')->take(10)->get(['id', 'name', 'thumbnail', 'price', 'status', 'user_id']);

        return view('frontend.layout.home', compact('packs'));
    }


    /**
     * Show Contact Us Page
     * @return View
     */
    public function contactPage()
    {
        $system = SystemSetting::latest('id')->first();
        return view('frontend.layout.contact', compact('system'));
    }


    /**
     * Send Admin Mail
     * @param Request $request
     * @return Redirect
     */
    public function AdminMail(Request $request)
    {

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'message' => 'required|string',
        ]);

        $admins = User::where('type', 'admin')->get();
       // Send notification to each admin (queued)
       try {
        foreach ($admins as $admin) {
            $admin->notify(new ContactFormNotification($validatedData));
        }
    } catch (\Exception $e) {
        Log::error('Notification Error: ' . $e->getMessage());
    }


    // Redirect back with success message
    return back()->with('t-success', 'Your message has been sent to the Support Team.');
    }


    /**
     * Show Contact Us Page
     * @return View
     */
    public function howToUsePage()
    {
        return view('frontend.layout.how-to-use');
    }

    /**
     * Show Dynamic page
     * @param string $slug
     * @return View
     */
    public function dynamicPage()
    {
        $page = DynamicPage::where('page_slug', request()->slug)->first();
        return view('frontend.layout.dynamic-page', compact('page'));
    }
}
