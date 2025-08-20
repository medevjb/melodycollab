<?php

namespace Database\Factories;

use App\Models\Email;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Email>
 */
class EmailFactory extends Factory
{

    public function definition(): array
    {

        return [
            'subject' => $this->faker->sentence,
            // 'slug' => 'a' . $this->faker->unique()->regexify('[A-Za-z0-9_-]{3,20}'),
            'content' => $this->faker->paragraphs(3, true),
        ];
    }
}
