<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('producer_name', 100)->nullable();
            $table->unsignedBigInteger('country_id')->nullable();
            $table->string('email', 100)->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');

            $table->string('beatstars_username')->nullable();
            $table->string('instagram_username')->nullable();
            $table->string('soundee_username')->nullable();
            $table->string('youtube_username')->nullable();
            $table->string('tiktok_username')->nullable();


            $table->string('avatar')->nullable();
            $table->string('cover')->nullable();
            $table->longText('about')->nullable();
            $table->boolean(column: 'is_subscribe')->default(false);

            $table->string('google_id')->nullable();

            $table->enum('type', ['admin', 'producer'])->default('producer');

            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
        // Creating admin
        User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('12345678'),
            'type' => 'admin',
            'email_verified_at' => now(),
        ]);
        // Creating producer
        User::create([
            'name' => 'producer',
            'email' => 'producer@gmail.com',
            'password' => Hash::make('12345678'),
            'type' => 'producer',
            'email_verified_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('users');
    }
};
