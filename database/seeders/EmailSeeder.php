<?php

namespace Database\Seeders;

use App\Models\Email;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Database\Factories\EmailFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class EmailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

     public function run()
     {
         $titles = [
             'Welcome and Initial Instructions',
             'Registration Confirmation',
             'Sample Pack Purchase Confirmation',
             'Abandoned Cart Reminder',
             'New Sample Pack Announcement',
             'Monthly Membership Subscription Confirmation',
             'Membership Cancellation Confirmation',
             'Account or Profile Update',
             'Newsletter',
             'Inactive User Reactivation',
             'Payment or Billing Notifications',
         ];

         foreach ($titles as $title) {
             if (!Email::where('title', $title)->exists()) {
                 Email::factory()->create([
                     'title' => $title,
                     'slug' => Str::slug($title),
                 ]);
             }
         }
     }

   /*  public function run()
    {
        $titles = [
            'Welcome and Initial Instructions',
            'Registration Confirmation',
            'Sample Pack Purchase Confirmation',
            'Abandoned Cart Reminder',
            'New Sample Pack Announcement',
            'Monthly Membership Subscription Confirmation',
            'Membership Cancellation Confirmation',
            'Account or Profile Update',
            'Newsletter',
            'Inactive User Reactivation',
            'Payment or Billing Notifications',
        ];

        foreach ($titles as $title) {
            Email::factory()->create([
                'title' => $title,
                'slug' => Str::slug($title),
            ]);
        }
    } */
}

