<?php

namespace App\Http\Controllers\Web\Producer;

use Exception;
use Stripe\Stripe;
use App\Models\User;
use Stripe\Customer;
use App\Models\Email;
use GuzzleHttp\Client;
use App\Helpers\Helper;
use Stripe\StripeClient;
use App\Models\Membership;
use App\Models\CardDetails;
use Illuminate\Http\Request;
use App\Models\UserMembership;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Notifications\MailNotification;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class PaymentController extends Controller
{
    /**
     * Pricing Pagr
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view("payment.pricing");
    }

    /**
     * Pricing Pagr
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function membership($type)
    {
        $membership = Membership::where('title', $type)->first();

        if ($membership && $membership->price == 0) {
            return redirect()->route('producer.dashboard')->with('t-success', "You have already subscribed.");
        } else if ($membership && $membership->price > 0) {
            return view("payment.membership", compact('membership'));
        } else {
            return redirect()->back()->with('t-error', 'Membership not found.');
        }
    }

    /**
     * Store Customer
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeSubscription(Request $request)
    {
        try {
            $userid = Auth::user()->id;
            $secrate = config('stripe.secrate_key');

            $stripe = new StripeClient($secrate);

            Stripe::setApiKey($secrate);
            $stripeData = $request->data;
            $customer = $this->createCustomer($stripeData['id']);
            if ($customer) {
                $customerId = $customer['id'];
                $plan = Membership::where('title', 'Pro')->first();

                // Membership Conditions Start
                $userSubscriptionDetails = UserMembership::where(['user_id' => $userid, 'status' => 'active', 'cancel' => 0])->orderBy('id', 'desc')->first();

                // If Change Subscription Monthly to yearly
                if ($userSubscriptionDetails && $userSubscriptionDetails->plan_interval == $plan->validity) {

                    return response()->json([
                        'success' => false,
                        'message' => 'You Already Have this Membership',
                    ]);

                } else {
                    // Fetch Subscription pending fees
                    $subscriptionStore = Helper::CreateUserMembershipMonthly($customerId, $userid, $plan, $stripe);
                    $message = "Congress! Your Monthly Membership is Activated";
                }

                // Store Data
                $cardDetails = $this->saveCardDetails($stripeData, $userid, $customerId);

                return response()->json([
                    'success' => true,
                    'message' => $message,
                ]);

            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Customer not created',
                ]);
            }

        } catch (\Exception $exception) {
            return response()->json([
                'success' => false,
                'data' => $exception->getMessage(),
            ]);
        }

        /*
         * Sending Mail Notification to the user when Monthly Membership Subscription Confirmation
         */
        $authuser = User::find(auth()->user()->id);
        $message = Email::where('id', 6)->select('subject', 'content')->first();

        if ($message) {
            // Log before sending notification for debugging
            Log::info('Sending notification to user: ' . $authuser->email);
            // dd($message->subject, $message->content);
            try {
                $data = $authuser->notify(new MailNotification($message->subject, $message->content)); // Send the notification
                Log::info('Notification sent successfully.');
                Log::info($data);
            } catch (\Exception $e) {
                Log::error('Failed to send notification: ' . $e->getMessage());
            }
        }
    }

    public function cancleUserMembership()
    {
        $user_id = Auth::user()->id;
        $userSubscriptionDetails = UserMembership::where([
            'user_id' => auth()->user()->id,
            'status' => 'active',
            'cancel' => 0,
        ])->orderBy('id', 'desc')->first();

        if ($userSubscriptionDetails) {
            if ($userSubscriptionDetails->method == 'stripe') {
                // Cancle Existing Subscription
                $stripeCancle = Helper::cancleCurrentMembership($user_id, $userSubscriptionDetails);

                if ($stripeCancle) {
                    return response()->json([
                        'success' => true,
                        'message' => 'Membership Canceled Successfully',
                    ]);
                }
            } elseif ($userSubscriptionDetails->method == 'paypal') {

                $subscriptionId = $userSubscriptionDetails->subscription_plan_price_id;

                if ($subscriptionId) {
                    // Initialize PayPal client
                    $provider = new PayPalClient();
                    $provider->setApiCredentials(config('paypal'));
                    $accessToken = $provider->getAccessToken();
                    $provider->setAccessToken($accessToken);

                        try {
                            $response = $provider->cancelSubscription($subscriptionId, 'User requested cancellation');
                            if (empty($response)) {
                                UserMembership::where('id', $userSubscriptionDetails->id)->update([
                                    'status' => 'cancelled',
                                    'cancel' => 1,
                                    'cancelled_at' => now(),
                                ]);
                                return response()->json([
                                    'success' => true,
                                    'message' => 'Membership Canceled Successfully',
                                ]);
                            }else{
                                return response()->json([
                                    'success' => false,
                                    'message' =>'Error cancelling PayPal subscription',
                                ]);
                            }
                        } catch (Exception $e) {
                            Log::error('Error cancelling PayPal subscription: ' . $e->getMessage());
                            return response()->json(['error' => $e->getMessage()], 500);
                    
                        }

                }

            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Membership not found',
                ]);
            }

        } else {
            return response()->json([
                'success' => false,
                'message' => 'Membership not found',
            ]);
        }

        /*
         * Sending Mail Notification to the user when Monthly Membership Subscription Cancel
         */
        $authuser = User::find(auth()->user()->id);
        $message = Email::where('id', 7)->select('subject', 'content')->first();

        if ($message) {
            // Log before sending notification for debugging
            Log::info('Sending notification to user: ' . $authuser->email);
            // dd($message->subject, $message->content);
            try {
                $data = $authuser->notify(new MailNotification($message->subject, $message->content)); // Send the notification
                Log::info('Notification sent successfully.');
                Log::info($data);
            } catch (\Exception $e) {
                Log::error('Failed to send notification: ' . $e->getMessage());
            }
        }
    }

    /**
     * Create customer On stripe
     * @param $token_id
     * @return \Stripe\Customer
     */
    public function createCustomer($token_id)
    {
        $customer = Customer::create([
            'name' => Auth::user()->name,
            'email' => Auth::user()->email,
            'source' => $token_id,
        ]);

        return $customer;
    }

    /**
     * Save Card Details
     * @param mix $cardDetails
     */
    public function saveCardDetails($cardData, $user_id, $customer_id)
    {
        CardDetails::updateOrCreate(
            [
                'user_id' => $user_id,
                'card_no' => $cardData['card']['last4'],
            ],
            [
                'user_id' => $user_id,
                'customer_id' => $customer_id,
                'card_id' => $cardData['card']['id'],
                'name' => $cardData['card']['name'],
                'card_no' => $cardData['card']['last4'],
                'brand' => $cardData['card']['brand'],
                'month' => $cardData['card']['exp_month'],
                'year' => $cardData['card']['exp_year'],
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
    }

    /**
     * Setup WebHooks For stripe
     * @param Request $request
     * @return JsonResponse
     */
    public function StripeWebhook(Request $request)
    {
        Log::info($request);

        $endpoint_secret = config('stripe.stripe_endpoint_secrate');

        $payload = @file_get_contents('php://input');
        $sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];
        $event = null;

        try {
            $event = \Stripe\Webhook::constructEvent(
                $payload,
                $sig_header,
                $endpoint_secret
            );
        } catch (\UnexpectedValueException $e) {
            // Invalid payload
            Log::error($e->getMessage());
            http_response_code(400);
            exit();
        } catch (\Stripe\Exception\SignatureVerificationException $e) {
            // Invalid signature
            Log::error($e->getMessage());
            http_response_code(400);
            exit();
        }

        // Handle the event
        switch ($event->type) {
            case 'customer.subscription.deleted':
                $subscription = $event->data->object;
                UserMembership::where('stripe_subscription_id', $subscription->id)->update([
                    'cancel' => true,
                    'status' => 'cancelled',
                    'cancelled_at' => now(),
                ]);
                break;

            case 'customer.subscription.paused':
                $subscription = $event->data->object;
                UserMembership::where('stripe_subscription_id', $subscription->id)->update([
                    'cancel' => true,
                    'status' => 'cancelled',
                    'cancelled_at' => now(),
                ]);
                break;
            case 'customer.subscription.resumed':
                $subscription = $event->data->object;
                UserMembership::where('stripe_subscription_id', $subscription->id)->update([
                    'cancel' => true,
                    'status' => 'cancelled',
                    'cancelled_at' => now(),
                ]);
                break;
            case 'invoice.payment_succeeded':
                $stripeSubscriptionId = $event->data->object->subscription;
                if ($stripeSubscriptionId) {
                    $stripeSubscription = $this->findSubscription($stripeSubscriptionId);
                    $this->handelSubscriptionPaid($stripeSubscription);
                }
                break;

            case 'subscription_schedule.aborted':
                $subscriptionSchedule = $event->data->object;
                UserMembership::where('stripe_subscription_id', $subscription->id)->update([
                    'cancel' => true,
                    'status' => 'cancelled',
                    'cancelled_at' => now(),
                ]);
                break;
            case 'subscription_schedule.canceled':
                $subscriptionSchedule = $event->data->object;
                UserMembership::where('stripe_subscription_id', $subscription->id)->update([
                    'cancel' => true,
                    'status' => 'cancelled',
                    'cancelled_at' => now(),
                ]);
                break;
            // ... handle other event types
            default:
                echo 'Received unknown event type ' . $event->type;
                UserMembership::where('stripe_subscription_id', $subscription->id)->update([
                    'cancel' => true,
                    'status' => 'cancelled',
                    'cancelled_at' => now(),
                ]);
                break;
        }
    }

    public function findSubscription($subscriptionId)
    {
        Stripe::setApiKey(config('stripe.secrate_key'));

        return \Stripe\Subscription::retrieve($subscriptionId);

    }

    /**
     * Hendel User Subscription
     */
    public function handelSubscriptionPaid($stripeSubscription)
    {

        $newPeriodEnd = $stripeSubscription->current_period_end;

        $userMembership = UserMembership::where('stripe_subscription_id', $stripeSubscription->id)->orderBy('id', 'desc')->first();

        if ($userMembership) {
            Stripe::setApiKey(config('stripe.secrate_key'));
            $user_id = $userMembership->user_id;

            if ($stripeSubscription->id == $userMembership->stripe_subscription_id) {
                $isRenewal = $newPeriodEnd > strtotime($userMembership->plan_period_end);
                if ($isRenewal) {
                    try {
                        $stripeSubscription = \Stripe\Subscription::retrieve($userMembership->stripe_subscription_id);
                    } catch (Exception $e) {
                        Log::error('Error Renewal Membership: ' . $e->getMessage());
                        $apiError = $e->getCode();
                    }

                    if (empty($apiError) && $stripeSubscription) {
                        $subscriptionData = $stripeSubscription->jsonSerialize();
                        UserMembership::where('user_id', $user_id)->orderBy('id', 'desc')->update([
                            'stripe_subscription_id' => $subscriptionData->id,
                            'plan_interval_count' => $subscriptionData['plan']['interval_count'],
                            'plan_period_end' => date('Y-m-d H:i:s', $stripeSubscription->current_period_end),
                        ]);
                    } else {
                        Log::error($apiError);
                    }
                }
            }
        }
    }

    /**
     * Show Payment Success Page
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function success()
    {
        return view("payment.success");
    }

}
