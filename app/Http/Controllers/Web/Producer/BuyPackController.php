<?php

namespace App\Http\Controllers\Web\Producer;

use Exception;
use App\Models\Pack;
use App\Models\User;
use App\Models\Order;
use App\Models\MyDownloads;
use PayPal\Rest\ApiContext;
use Illuminate\Http\Request;
use App\Models\SystemSetting;
use App\Models\ProducerPaypal;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Crypt;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class BuyPackController extends Controller
{

    protected $apiContext;

    public function __construct()
    {
        $this->apiContext = new \PayPal\Rest\ApiContext(
            new \PayPal\Auth\OAuthTokenCredential(
                config('paypal.sandbox.client_id'), // Client ID from PayPal Developer Portal
                config('paypal.sandbox.client_secret') // Secret from PayPal Developer Portal
            )
        );
        $this->apiContext->setConfig([
            'mode' => 'sandbox', // Or 'live' for production
            'http.ConnectionTimeOut' => 30,
            'log.LogEnabled' => true,
            'log.FileName' => storage_path('logs/paypal.log'),
            'log.LogLevel' => 'DEBUG', // Use 'INFO' for production
            'validation.level' => 'log',
            'cache.enabled' => true,
        ]);
    }

    /**
     * Buy Pack
     * @param $id
     */
    public function buyPack($id)
    {
        $pack = Pack::findOrFail(Crypt::decrypt($id))->load('user');
        if (Order::where('user_id', $pack->user_id)->where('pack_id', $pack->id)->exists()) {
            return redirect()->back()->with("t-error", "You already buy this pack.");
        }
        if ($pack == null) {
            return redirect()->back()->with("t-error", "Pack not found.");
        }
        $userPaypal = ProducerPaypal::where('user_id', $pack->user_id)->first();
        if ($userPaypal == null) {
            return redirect()->back()->with("t-error", "Producer not ready to sell.");
        }
        $price = $pack->price;
        $setting = SystemSetting::latest('id')->first();
        if($setting || $setting->commission != null) {
            $price = $price - ($price * $setting->commission) / 100;
        }

        if ($pack->user->hasMembership()) {
            // 5% Discount For Premium Members
            $price = $price - ($price * 5) / 100;
        }

        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $paypalToken = $provider->getAccessToken();
        $response = $provider->createOrder([
            "intent" => "CAPTURE",
            "application_context" => [
                "return_url" => route('producer.buy.pack.success.paypal') . '?pack_id=' . Crypt::encrypt($pack->id),
                "cancel_url" => route('producer.buy.pack.cancel.paypal'),
            ],
            "purchase_units" => [
                0 => [
                    "amount" => [
                        "currency_code" => "USD",
                        "value" => $price,
                    ],
                ],
            ],
        ]);
        if (isset($response['id']) && $response['id'] != null) {
            // redirect to approve href
            foreach ($response['links'] as $links) {
                if ($links['rel'] == 'approve') {
                    return redirect()->away($links['href']);
                }
            }
            return redirect()
                ->route('producer.buy.pack.cancel.paypal')
                ->with('t-error', 'Something went wrong.');
        } else {
            return redirect()
                ->route('producer.buy.pack.cancel.paypal')
                ->with('t-error', $response['message'] ?? 'Something went wrong.');
        }
    }

    private function getPayPalAccessToken()
    {
        $clientId = config('paypal.sandbox.client_id');
        $secret = config('paypal.sandbox.client_secret');
        $apiUrl = config('paypal.sandbox.api_url') . '/v1/oauth2/token';

        $response = Http::withBasicAuth($clientId, $secret)
            ->asForm()
            ->post($apiUrl, [
                'grant_type' => 'client_credentials',
            ]);

        if ($response->successful()) {
            return $response->json()['access_token'];
        }

        Log::error('Error fetching PayPal Access Token: ' . $response->body());
        return null;
    }

    private function sendPayPalPayout($accessToken, $payoutData)
    {
        $apiUrl = config('paypal.mode') === 'sandbox'
        ? config('paypal.sandbox.api_url') . '/v1/payments/payouts'
        : config('paypal.live.api_url') . '/v1/payments/payouts';

        // Send the payout request to PayPal
        $response = Http::withToken($accessToken)
            ->withHeaders([
                'Content-Type' => 'application/json',
            ])
            ->post($apiUrl, $payoutData);

        // Check if the response is successful
        if ($response->successful()) {
            return $response->json();
        } else {
            // Log the error and return the error message
            Log::error('PayPal Payout Error: ' . $response->body());

            // Optionally throw an exception or return a more detailed error response
            return [
                'status' => 'error',
                'message' => 'PayPal Payout failed',
                'details' => $response->json(),
            ];
        }
    }

    /**
     * success transaction.
     */
    public function successTransaction(Request $request)
    {

        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();
        $response = $provider->capturePaymentOrder($request['token']);
        if (isset($response['status']) && $response['status'] == 'COMPLETED') {

            $payedAmount = $response['purchase_units'][0]['payments']['captures'][0]['amount']['value'];

            // Decrypt and fetch the pack information
            $pack = Pack::where('id', Crypt::decrypt($request->pack_id))->first();
            if ($pack == null) {
                return redirect()->route("producer.dashboard")->with("t-error", "Pack not found.");
            }

            // Get the producer's user information and PayPal details
            $packUser = User::where('id', $pack->user_id)->first();
            if ($packUser->paypal_email == null) {
                return redirect()->route("producer.dashboard")->with("t-error", "You can't buy this pack. Producer hasn't set their PayPal account.");
            }

            // PayPal payout functionality: Pay the producer
            try {
                $producerPaypalEmail = $packUser->paypal_email; // Producer's PayPal email
                $payoutResponse = $this->sendPayPalPayout($this->getPayPalAccessToken(), [
                    'sender_batch_header' => [
                        'sender_batch_id' => 'batch-' . time(),
                        'email_subject' => 'PayPal Payout',
                    ],
                    'items' => [
                        [
                            'recipient_type' => 'EMAIL',
                            'amount' => [
                                'value' => $payedAmount,
                                'currency' => 'USD',
                            ],
                            'note' => 'Thanks for your patronage!',
                            'receiver' => $producerPaypalEmail,
                            'sender_item_id' => 'item_' . time(),
                        ],
                    ],
                ]);
                if (is_array($payoutResponse)) {
                    if (isset($payoutResponse['batch_header']['batch_status']) && $payoutResponse['batch_header']['batch_status'] !== 'SUCCESS') {
                        Log::error('PayPal Payout Error: ' . json_encode($payoutResponse));

                        Order::created([
                            'user_id' => $pack->user_id,
                            'pack_id' => $pack->id,
                            'price' => $payedAmount,
                        ]);

                        MyDownloads::create([
                            'user_id' => $pack->user_id,
                            'pack_id' => $pack->id,
                            'type' => 'pack',
                        ]);

                        return redirect()
                            ->route('producer.dashboard')
                            ->with('t-success', 'Purchase Complete');
                    } else {

                        Order::created([
                            'user_id' => $pack->user_id,
                            'pack_id' => $pack->id,
                            'price' => $payedAmount,
                        ]);

                        MyDownloads::create([
                            'user_id' => $pack->user_id,
                            'pack_id' => $pack->id,
                            'type' => 'pack',
                        ]);

                        // Payout was successful
                        return redirect()
                            ->route('producer.dashboard')
                            ->with('t-success', 'Transaction complete, and payment sent to producer.');
                    }
                } else {
                    // Fallback if response is not an array (edge case)
                    Log::error('Unexpected PayPal Payout Response: ' . $payoutResponse);
                    return redirect()
                        ->route('producer.dashboard')
                        ->with('t-success', 'Transaction complete, but payment to producer failed. Please contact support.');
                }

            } catch (Exception $e) {
                Log::error('PayPal Payout Exception: ' . $e->getMessage());
                return redirect()
                    ->route('producer.dashboard')
                    ->with('t-success', 'Transaction complete, but an error occurred while paying the producer.');
            }

        } else {
            return redirect()
                ->route('producer.dashboard')
                ->with('t-error', $response['message'] ?? 'Something went wrong.');
        }

    }

    /**
     * cancel transaction.
     */
    public function cancelTransaction(Request $request)
    {
        return redirect()
            ->route('producer.buy.pack.cancel.paypal')
            ->with('t-error', $response['message'] ?? 'You have canceled the transaction.');
    }
}
