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
        Schema::create('memberships', function (Blueprint $table) {
            $table->id();

            $table->string('title');
            $table->enum('validity', ['month', 'year'])->default('month');
            $table->float('price');
            $table->text('description');
            $table->integer('trail')->default(0);
            $table->text('product_id')->nullable();
            $table->text('stripe_price_id')->nullable();
            $table->enum('typpe', ['free', 'pro'])->default('free');
            $table->string('paypal_plan_id')->nullable();

            $table->enum('status', ['active', 'inactive'])->default('active');


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('memberships');
    }
};
