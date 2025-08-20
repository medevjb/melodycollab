<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('melodies', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnUpdate()
                ->restrictOnDelete();
            $table->string('name');
            $table->string('thumbnail')->nullable();
            $table->string('file');
            $table->integer('bpm')->nullable();
            $table->string('key')->nullable();
            $table->integer('split')->nullable();
            $table->enum('type',['melody', 'demo'])->default('melody');
            $table->unsignedBigInteger('pack_id')->nullable();
            $table->string('pdf')->nullable();

            $table->integer('playes')->default(1);
            $table->integer('downloads')->default(1);

            $table->enum('status', ['active','inactive'])->default('active');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('melodies');
    }
};
