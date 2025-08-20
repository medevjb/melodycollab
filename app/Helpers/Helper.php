<?php

namespace App\Helpers;

use Stripe\Stripe;
use App\Models\User;
use Stripe\Subscription;
use Illuminate\Support\Str;
use App\Models\UserMembership;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Crypt;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class Helper
{
    public static function fileUpload($file, $folder, $name)
    {
        if (!$file->isValid()) {
            return null;
        }

        $imageName = Str::slug($name) . '.' . $file->extension();
        $path = public_path('uploads/' . $folder);
        if (!file_exists($path)) {
            mkdir($path, 0755, true);
        }
        $file->move($path, $imageName);
        return 'uploads/' . $folder . '/' . $imageName;
    }

    // Make Slug
    public static function makeSlug($model, string $title): string
    {
        $slug = Str::slug($title);
        while ($model::where('slug', $slug)->exists()) {
            $randomString = Str::random(5);
            $slug = Str::slug($title) . '-' . $randomString;
        }
        return $slug;
    }

    public static function CreateUserMembershipMonthly($customer_id, $user_id, $subscriptionPlan, $stripe)
    {

        $subscription = null;

        $milisecoundDate = strtotime(date('Y-m-') . '01');
        $current_period_start = date("Y-m-d", strtotime("+1 month", $milisecoundDate)) . ' 00:00:00';
        $current_period_end = date("Y-m-t", strtotime("+1 month")) . " 23:59:59";
        log::info($customer_id);

        $stripeData = $stripe->subscriptions->create([
            'customer' => $customer_id,
            'items' => [
                ['price' => $subscriptionPlan->stripe_price_id ?? 'price_1Q2ogXBanWWo7KdEWnFfrqAY'],
            ],
            // 'billing_cycle_anchor' => strtotime($current_period_start),
            // 'proration_behavior' => 'none',
            'trial_period_days' => 7,
        ]);

        log::info($stripeData);

        $stripeCharge = $stripeData->jsonSerialize();
        if (!empty($stripeCharge)) {

            $subscriptionId = $stripeCharge['id'];
            $customerId = $stripeCharge['customer'];

            if (!empty($stripeCharge['items'])) {
                $planId = $stripeCharge['items']['data']['0']['plan']['id'];
            } else {
                $planId = $stripeCharge['plan']['id'];
            }

            $priceData = $stripe->plans->retrieve(
                $planId,
                []
            );

            log::info($priceData);

            $planAmount = ($priceData->amount / 100);
            $planCurrency = $priceData->currency;
            $planInterval = $priceData->interval;
            $planIntervalCount = $priceData->interval_count;

            $created = date('Y-m-d H:i:s', $stripeCharge['created']);

        }

        try {
            $data = [
                'user_id' => $user_id,
                'stripe_subscription_id' => $subscriptionId,
                'stripe_subscription_schedule_id' => '',
                'customer_id' => $customerId,
                'subscription_plan_price_id' => $planId,
                'plan_amount' => $planAmount,
                'plan_currency' => $planCurrency,
                'plan_interval' => $planInterval,
                'plan_interval_count' => $planIntervalCount,
                'created' => $created,
                'plan_period_start' => $current_period_start,
                'created_at' => now(),
                'updated_at' => now(),
            ];

            $subscription = UserMembership::insert($data);
            User::where('id', $user_id)->update(['is_subscribe' => true]);

            if ($subscription != null) {
                return "Membership created successfully";
            } else {
                return "Failed to create membership";
            }

        } catch (\Exception $exception) {
            return $exception->getMessage();
        }
    }

    // Cancel Subscription
    public static function cancleCurrentMembership($userid, $userSubscriptionDetails)
    {

        try {
            $secrate = config('stripe.secrate_key');
            Stripe::setApiKey($secrate);

            if ($userSubscriptionDetails->stripe_subscription_id != null) {
                $currentSubscription = Subscription::retrieve($userSubscriptionDetails->stripe_subscription_id);
                Log::info($currentSubscription);
                $currentSubscription->cancel();
            }

            UserMembership::where('id', $userSubscriptionDetails->id)->update([
                'status' => 'cancelled',
                'cancel' => 1,
                'cancelled_at' => now(),
            ]);

            User::where('id', $userid)->update([
                'is_subscribe' => false,
            ]);
            return true;

        } catch (\Exception $exception) {
            Log::info($exception->getMessage());
            return false;
        }

    }

    // Paypal Payment
    // Intigration
    public static function CreatePlanOnPaypal()
    {

        $provider = new PayPalClient();
        $provider->setApiCredentials(config('paypal'));
        $accessToken = $provider->getAccessToken();
        $provider->setAccessToken($accessToken);

        $product = $provider->createProduct([
            'name' => 'Premium Subscription',
            'description' => 'Access to premium content',
            'type' => 'SERVICE',
            'category' => 'SOFTWARE',
        ]);

        $productId = $product['id'];

        $plan = $provider->createPlan([
            'product_id' => $productId,
            'name' => 'Premium Plan',
            'description' => 'Monthly subscription to premium features',
            'status' => 'ACTIVE',
            'billing_cycles' => [
                // First billing cycle should be the trial
                [
                    'frequency' => [
                        'interval_unit' => 'DAY',
                        'interval_count' => 7, 
                    ],
                    'tenure_type' => 'TRIAL', 
                    'sequence' => 1,
                    'total_cycles' => 1,
                    'pricing_scheme' => [
                        'fixed_price' => [
                            'value' => '0.00',
                            'currency_code' => 'USD',
                        ],
                    ],
                ],
                // Then, add the regular billing cycle
                [
                    'frequency' => [
                        'interval_unit' => 'MONTH',
                        'interval_count' => 1,
                    ],
                    'tenure_type' => 'REGULAR', // Set the tenure type as REGULAR
                    'sequence' => 2,
                    'total_cycles' => 0,
                    'pricing_scheme' => [
                        'fixed_price' => [
                            'value' => '9.99',
                            'currency_code' => 'USD',
                        ],
                    ],
                ],
            ],
            'payment_preferences' => [
                'auto_bill_outstanding' => true,
                'setup_fee' => [
                    'value' => '0.00',
                    'currency_code' => 'USD',
                ],
                'setup_fee_failure_action' => 'CANCEL',
                'payment_failure_threshold' => 3,
            ],
        ]);

        $planId = $plan['id'];
        return $planId;
    }


    public static function ClientPaypalConfig($client_id, $client_secret){
        return [
            'mode' => 'sandbox', // Can only be 'sandbox' Or 'live'. If empty or invalid, 'live' will be used.
            'sandbox' => [
                'client_id' => Crypt::decrypt($client_id),
                'client_secret' => Crypt::decrypt($client_secret),
            ],
            'live' => [
                'client_id' => Crypt::decrypt($client_id),
                'client_secret' => Crypt::decrypt($client_secret),
            ],
            'settings' => [
                'mode' => env('PAYPAL_MODE', 'sandbox'), // or 'live' for production
                'http.ConnectionTimeOut' => 30,
                'log.LogEnabled' => true,
                'log.FileName' => storage_path('logs/paypal.log'),
                'log.LogLevel' => 'DEBUG',
            ],

            'payment_action' => env('PAYPAL_PAYMENT_ACTION', 'Sale'), 
            'currency' =>'USD',
            'notify_url' => env('PAYPAL_NOTIFY_URL', ''), 
            'locale' => env('PAYPAL_LOCALE', 'en_US'), 
            'validate_ssl' => env('PAYPAL_VALIDATE_SSL', true),
        ];
    }

}
