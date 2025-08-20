<?php

namespace Database\Seeders;

use App\Models\Membership;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class MembershipSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $member = [
            [
                'title' => 'Free',
                'description' => 'Create your free account to have access to all of this:',
                'price' => 0,
            ],
            [
                'title'=> 'Pro',
                'description'=> 'Take your producer career to the next level',
                'price'=> 9.99,
            ],
        ];

        foreach ($member as $value) {
           Membership::create($value);
        }
    }
}
