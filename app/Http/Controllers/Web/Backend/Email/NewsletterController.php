<?php

namespace App\Http\Controllers\Web\Backend\Email;

use App\Models\User;
use App\Models\Email;
use App\Jobs\ProcessEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class NewsletterController extends Controller
{

    //Show Mail View
    public function index($slug)    {

        $email = Email::where('slug', $slug)->first();
        if (!$email) {
            return redirect()->back()->with('t-error', 'Email Not found.');
        }

        return view('backend.layouts.newsletter.index', compact('email'));
    }




   /*  Send Mail Function start */
    public function sendMail(Request $request)
    {
        // dd($request->all());
        $validatedData = $request->validate([
            'subject' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        // Prepare the email data
        $subject = $validatedData['subject'];
        $content = $validatedData['content'];
        $users = User::where('type', 'producer')->get();

        // Dispatch the job
        try {
            ProcessEmail::dispatch($subject, $content, $users);
            return redirect()->back()->with('t-success', 'Thank you. Your message has been sent.');
        } catch (\Exception $e) {
            return redirect()->back()->with('t-error', 'Failed to send message: ' . $e->getMessage());
        }
    }
    /* Send Mail Function end */
}
