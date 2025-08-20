<?php

namespace App\Http\Controllers\Web\Producer;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\Membership;
use App\Models\User;
use App\Models\UserMembership;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class PaypalController extends Controller
{
    /**
     * Paypal Membershiip Checkout Page
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function paypalCheckout()
    {
        $subscriptionPlan = Membership::where('typpe', 'pro')->first();
        if ($subscriptionPlan == null) {
            return redirect()->back()->with('t-error', 'Membership not found.');
        }
        if ($subscriptionPlan->paypal_plan_id == null) {
            $planId = Helper::CreatePlanOnPaypal();
            $subscriptionPlan->paypal_plan_id = $planId;
            $subscriptionPlan->save();
        } else {
            $planId = $subscriptionPlan->paypal_plan_id;
        }

        $provider = new PayPalClient();
        $provider->setApiCredentials(config('paypal'));
        $accessToken = $provider->getAccessToken();
        $provider->setAccessToken($accessToken);

        $PaypalSubscription = $provider->createSubscription([
            'plan_id' => $planId,          
            'application_context' => [
                'brand_name' => 'Melody Collab',
                'locale' => 'en-US',
                'shipping_preference' => 'NO_SHIPPING',
                'user_action' => 'SUBSCRIBE_NOW',
                'return_url' => route('producer.success.paypal'),
                'cancel_url' => route('producer.cancel.paypal'),
            ],
            'subscriber' => [
                'name' => [
                    'given_name' => Auth::user()->name,
                ],
                'email_address' => Auth::user()->email,
            ],
        ]);

        // Redirect the user to PayPal to approve the subscription
        return redirect($PaypalSubscription['links'][0]['href']);
    }
    /**
     * success transaction.
     *
     * @return \Illuminate\Http\Response
     */
    public function successTransaction(Request $request)
    {
        // Get the subscription ID from the query string
        $subscriptionId = $request->query('subscription_id');

        // Initialize PayPal Client
        $provider = new PayPalClient();
        $provider->setApiCredentials(config('paypal'));
        $accessToken = $provider->getAccessToken();
        $provider->setAccessToken($accessToken);

        try {
            $subscriptionDetails = $provider->showSubscriptionDetails($subscriptionId);

            if ($subscriptionDetails['status'] == 'ACTIVE') {
                $data = [
                    'user_id' => Auth::user()->id,
                    'subscription_plan_price_id' => $subscriptionDetails['id'],
                    'plan_amount' => $subscriptionDetails['shipping_amount']['value'],
                    'plan_currency' => $subscriptionDetails['shipping_amount']['currency_code'],
                    'plan_interval' => $subscriptionDetails['billing_info']['cycle_executions'][0]['cycles_completed'],
                    'plan_interval_count' => $subscriptionDetails['billing_info']['cycle_executions'][0]['total_cycles'],
                    'created' => date('Y-m-d'),
                    'plan_period_start' => date('Y-m-d H:i:s', strtotime($subscriptionDetails['billing_info']['next_billing_time'])),
                    'plan_period_end' => date('Y-m-d H:i:s', strtotime($subscriptionDetails['billing_info']['next_billing_time'])),
                    'trial_ends_at' => date('Y-m-d H:i:s', strtotime($subscriptionDetails['billing_info']['next_billing_time'])),
                    'method' => 'paypal',
                    'created_at' => now(),
                    'updated_at' => now(),
                ];

                $subscription = UserMembership::insert($data);
                User::where('id', Auth::user()->id)->update(['is_subscribe' => true]);

                return view('payment.success');
            } else {
                return redirect()->route('producer.cancel.paypal')->with('t-error', 'Payment could not be verified.');
            }
        } catch (\Exception $e) {
            Log::error('Error verifying PayPal subscription: ' . $e->getMessage());
            return redirect()->route('producer.cancel.paypal')->with('t-error', 'An error occurred while processing your payment.');
        }

    }
    /**
     * cancel transaction.
     */
    public function cancelTransaction(Request $request)
    {
        return redirect()
            ->route('producer.dashboard')
            ->with('t-error', $response['message'] ?? 'You have canceled the transaction.');
    }

    /**
     * Success transaction.
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function successPaypal(Request $request)
    {

        return view('payment.success');
    }
}
