<?php

namespace App\Jobs;

use Exception;
use App\Models\User;
use App\Mail\YourMailable;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ProcessEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $title;
    public $content;
    public $users;

    // Create a new job instance.
    public function __construct($title, $content, $users)
    {
        $this->title = $title;
        $this->content = $content;
        $this->users = $users;

    }

    public function handle(): void
    {
        // dd($this->users);
        foreach ($this->users as $user) {
            Log::info($user->email);
            try {
                // Create a new instance of YourMailable with the email data
                $mail = new YourMailable($this->title, $this->content);
                // Send the email
                Mail::to($user->email)->send($mail);
            } catch (\Exception $e) {
                Log::error('Error sending email: ' . $e->getMessage());
            }
        }
    }
}
