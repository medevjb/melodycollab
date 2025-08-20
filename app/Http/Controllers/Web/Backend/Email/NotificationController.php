<?php

namespace App\Http\Controllers\Web\Backend\Email;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Notifications\MailNotification;

class NotificationController extends Controller
{

    // Show Mail View
    public function index()
    {
        return view('backend.layouts.notification.index');
    }


    // Send mail Function
    public function MailSend(Request $request)
    {
        // dd($request->all());
        $validatedData = $request->validate([
            'subject' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        // Get all users of type 'producer'
        $users = User::where('type', 'producer')->get();

        // Send notification to the users

        foreach ($users as $user) {
            $user->notify(new MailNotification($validatedData['subject'], $validatedData['content']));
        }

        return redirect()->back()->with('t-success', 'Notifications sent successfully!');
    }
}
