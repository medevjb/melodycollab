<?php

namespace App\Http\Controllers\Web\Producer;

use App\Models\Cart;
use App\Models\Pack;
use App\Models\User;
use App\Models\Email;
use App\Helpers\Helper;
use App\Models\CartItem;
use App\Models\MyDownloads;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Notifications\MailNotification;
use Illuminate\Notifications\Notifiable;

class CartController extends Controller
{
    /**
     * add To cart
     * @param Request $request
     */
    public function addToCart(Request $request)
    {
        $pack = Pack::find($request->id)->load('user');
        if($pack->user->id == auth()->user()->id){
            return response()->json([
                'success' => false,
                'data' => [],
                'message' => 'You can not buy your own pack',
            ]);
        }
        if (!$pack) {
            return response()->json([
                'success' => false,
                'data' => [],
                'message' => 'Pack not found',
            ]);
        }
        $cart = Cart::where('user_id', auth()->user()->id)->first();

        if (!$cart) {
            $cart = Cart::create([
                'user_id' => auth()->user()->id,
            ]);
        }
        $itemExist = CartItem::where('cart_id', $cart->id)->where('pack_id', $pack->id)->first();
        if ($itemExist) {
            return response()->json([
                'success' => false,
                'data' => [],
                'message' => 'Item already exist in cart',
            ]);
        }

        // If Already Purchase
        $purchaseCheck = MyDownloads::where('user_id', auth()->user()->id)
            ->where('pack_id', $pack->id)
            ->where('type', 'pack')
            ->first();
        if ($purchaseCheck) {
            return response()->json([
                'success' => false,
                'data' => [],
                'message' => 'Item already exist in purchase',
            ]);
        }

        $item = CartItem::create([
            'cart_id' => $cart->id,
            'pack_id' => $pack->id,
            'price' => $pack->price,
        ]);

        return response()->json([
            'success' => true,
            'data' => [
                'cart' => $cart,
                'item' => $item ?? null,
                'pack' => $pack,
            ],
            'message' => 'Cart Added Successfully',
        ]);


        /*
         * Sending Mail Notification to the user when the item is added to the cart
         */
        $authuser = User::find(auth()->user()->id);
        $message = Email::where('id', 4)->select('subject', 'content')->first();
        if ($message) {
            // Log before sending notification for debugging
            Log::info('Sending notification to user: ' . $authuser->email);
            // dd($message->subject, $message->content);
            $data = $authuser->notify(new MailNotification($message->subject, $message->content)); // Send the notification
            Log::info('Notification sent successfully.');
            Log::info($data);
        }
    }




    /**
     * Remove From Cart
     * @param Request $request
     */
    public function removeFromCart(Request $request)
    {
        $item = CartItem::where('id', $request->id)->with('pack')->first();
        if (!$item) {
            return response()->json([
                'success' => false,
                'data' => [],
                'message' => 'Item not found',
            ]);
        }
        $item->delete();
        return response()->json([
            'success' => true,
            'pack' => $item->pack,
            'message' => 'Item Removed Successfully',
        ]);
    }

    /**
     * Remove All From Cart
     */
    public function removeAllFromCart()
    {
        $cart = Cart::where('user_id', auth()->user()->id)->first();
        if (!$cart) {
            return response()->json([
                'success' => false,
                'data' => [],
                'message' => 'Cart not found',
            ]);
        }
        $cart->items()->delete();
        return response()->json([
            'success' => true,
            'message' => 'Cart Items Removed Successfully',
        ]);
    }
}
