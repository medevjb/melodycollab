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
        Schema::create('user_memberships', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('stripe_subscription_id')->nullable();
            $table->string('stripe_subscription_schedule_id')->default('');
            $table->string('customer_id')->nullable();
            $table->string('subscription_plan_price_id');
            $table->string('plan_amount');
            $table->string('plan_currency');
            $table->string('plan_interval');
            $table->string('plan_interval_count');
            $table->date('created');
            $table->timestamp('plan_period_start')->nullable();
            $table->timestamp('plan_period_end')->nullable();

            $table->timestamp('trial_ends_at')->nullable();
            $table->enum('method', ['stripe', 'paypal'])->default('stripe');

            $table->enum('status', ['active', 'cancelled'])->default('active');
            $table->boolean('cancel')->default(false);
            $table->timestamp('cancelled_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_memberships');
    }
};
