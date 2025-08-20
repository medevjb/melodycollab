<?php

namespace App\Http\Controllers\Web\Backend\Email;

use App\Models\Email;
use App\Helpers\Helper;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EmailController extends Controller
{

    //Edit Email
    public function edit($slug)
    {

        $email = Email::where('slug', $slug)->first();

        if (!$email) {
            return redirect()->back()->with('t-error', 'Email not found.');
        }

        return view('backend.layouts.email.edit', compact('email'));
    }



    //Update Email
    public function update(Request $request)
    {

        //dd($request->all());

        // Validation rules
        $request->validate([
            'email_id' => 'required',
            'subject' => 'required|string|max:255',
            'content' => 'required|string',
        ]);


        $email = Email::findOrFail($request->email_id);

        // Update email fields with incoming data
        $email->subject = $request->input('subject');
        // $email->slug = Str::slug($request->input('subject'));
        $email->content = $request->input('content');
        $email->save();

        return redirect()->route('email.edit', ['id' => $email->id , 'slug' => $email->slug])->with('t-success', 'Email updated successfully.');
    }
}
