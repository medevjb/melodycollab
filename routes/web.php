<?php

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\Web\Frontend\HomeController;
use App\Http\Controllers\Web\Producer\MelodyController;
use App\Http\Controllers\Web\Producer\PaymentController;
use App\Http\Controllers\Web\Producer\PayPalWebhookControllerController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
 */
Auth::routes();

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/contact', [HomeController::class, 'contactPage'])->name('contact.us');
Route::get('/how-to-use', [HomeController::class, 'howToUsePage'])->name('how.to.use');


// Dynamic Pages
Route::get('page/{slug}', [HomeController::class, 'dynamicPage'])->name('dynamic.page');


Route::post('/producer/update-thumbnail-picture', [MelodyController::class, 'uploadThumbnail'])->name('upload.thumb');


Route::get('/pricing',[PaymentController::class,'index'])->name('pricing');

Route::get('auth/google', [GoogleController::class, 'loginWithGoogle'])->name('google.login');
Route::get('auth/google/callback', [GoogleController::class, 'callbackFromGoogle'])->name('google.callback');

Route::post('/stripe-webhook', [PaymentController::class, 'StripeWebhook'])->name('stripe.webhook');

Route::post('/webhook/paypal', [PayPalWebhookControllerController::class, 'handleWebhook'])->name('webhook.paypal');

// Route for AdminMail from users
Route::controller(HomeController::class)->group(function () {
    Route::post('/contact-sends','AdminMail')->name('contact.AdminMail');
});

Route::get('/setusername', function () {
    $users = App\Models\User::all();

    foreach ($users as $user) {
        $user->update([
            'username' => Str::slug($user->producer_name??$user->name),
        ]);
    }
});
