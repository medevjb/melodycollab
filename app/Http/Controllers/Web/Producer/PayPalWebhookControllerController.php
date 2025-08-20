<?php

namespace App\Http\Controllers\Web\Producer;

use Illuminate\Http\Request;
use App\Models\UserMembership;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class PayPalWebhookControllerController extends Controller
{
     /**
     * Handle incoming PayPal webhook events.
     */
    public function handleWebhook(Request $request)
    {
        // Log the webhook payload for debugging
        Log::info('PayPal Webhook Payload: ', $request->all());

        // Get the event type
        $event = $request->input('event_type');

        switch ($event) {
            case 'BILLING.SUBSCRIPTION.CREATED':
                $this->handleSubscriptionCreated($request);
                break;
            case 'BILLING.SUBSCRIPTION.ACTIVATED':
                $this->handleSubscriptionActivated($request);
                break;
            case 'BILLING.SUBSCRIPTION.CANCELLED':
                $this->handleSubscriptionCancelled($request);
                break;
            case 'BILLING.SUBSCRIPTION.RENEWED':
                $this->handleSubscriptionRenewed($request);
                break;
            case 'PAYMENT.SALE.COMPLETED':
                $this->handlePaymentCompleted($request);
                break;
            default:
                Log::warning('Unhandled PayPal Webhook Event: ' . $event);
                break;
        }

        // Respond with a 200 status code to acknowledge receipt of the webhook
        return response()->json(['status' => 'success']);
    }

    private function handleSubscriptionCreated($request)
    {
        // Logic for handling when a subscription is created
        $subscriptionId = $request->input('resource.id');
        Log::info("Subscription Created: $subscriptionId");
        // You can save the subscription details to your database here
    }

    private function handleSubscriptionActivated($request)
    {
        // Logic for handling when a subscription is activated
        $subscriptionId = $request->input('resource.id');
        Log::info("Subscription Activated: $subscriptionId");
        // Update subscription status in your database
    }

    private function handleSubscriptionCancelled($request)
    {
        // Logic for handling when a subscription is cancelled
        $subscriptionId = $request->input('resource.id');
        $userMembership = UserMembership::where('subscription_plan_price_id', $subscriptionId)->orderBy('id', 'desc')->first();

        if ($userMembership) {
            $userMembership->status = 'cancelled';
            $userMembership->cancelled_at = now();
            $userMembership->cancel = 1;
            $userMembership->save();
        }
        Log::info("Subscription Cancelled: $subscriptionId");
        // Update subscription status in your database
    }

    private function handleSubscriptionRenewed($request)
    {
        // Logic for handling when a subscription is renewed
        $subscriptionId = $request->input('resource.id');

        $userMembership = UserMembership::where('subscription_plan_price_id', $subscriptionId)->orderBy('id', 'desc')->first();

        if ($userMembership) {
            $userMembership->status = 'active';
            $userMembership->cancelled_at = null;
            $userMembership->cancel = 0;
            $userMembership->plan_period_end = date('Y-m-d H:i:s', $request->input('resource.current_period_end'));
            $userMembership->save();
        }

        Log::info("Subscription Renewed: $subscriptionId");
        // Update subscription status in your database
    }

    private function handlePaymentCompleted($request)
    {
        // Logic for handling successful payments
        $paymentId = $request->input('resource.id');
        $userMembership = UserMembership::where('subscription_plan_price_id', $paymentId)->orderBy('id', 'desc')->first();

        if ($userMembership) {
            $userMembership->status = 'active';
            $userMembership->cancelled_at = null;
            $userMembership->cancel = 0;
            $userMembership->plan_period_end = date('Y-m-d H:i:s', $request->input('resource.current_period_end'));
            $userMembership->save();
        }
        Log::info("Payment Completed: $paymentId");
        // Update payment status in your database
    }
}
