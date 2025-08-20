<?php

/*
|--------------------------------------------------------------------------
| Producers Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
 */

use App\Http\Controllers\Web\Producer\BrowseController;
use App\Http\Controllers\Web\Producer\BuyPackController;
use App\Http\Controllers\Web\Producer\CartController;
use App\Http\Controllers\Web\Producer\CheckoutController;
use App\Http\Controllers\Web\Producer\DashboardController;
use App\Http\Controllers\Web\Producer\FeedController;
use App\Http\Controllers\Web\Producer\FollowerController;
use App\Http\Controllers\Web\Producer\HomeController;
use App\Http\Controllers\Web\Producer\MarketPlaceController;
use App\Http\Controllers\Web\Producer\MelodyController;
use App\Http\Controllers\Web\Producer\PackController;
use App\Http\Controllers\Web\Producer\PackDemoController;
use App\Http\Controllers\Web\Producer\PaymentController;
use App\Http\Controllers\Web\Producer\PaypalController;
use App\Http\Controllers\Web\Producer\ProducerController;
use App\Http\Controllers\Web\Producer\ProfileController;
use App\Http\Controllers\Web\Producer\SearchController;
use Illuminate\Support\Facades\Route;

Route::controller(DashboardController::class)->group(function () {
    Route::get('dashboard', 'index')->name('dashboard');
    Route::get('get-download-graph-data', 'getDownloadGraphData');
    Route::get('get-sales-graph-data', 'getSalesGraphData');

});

Route::controller(HomeController::class)->group(function () {
    Route::get('my/downloads','myDownloads')->name('my.downloads');
    Route::get('my/recent','recentDownloads')->name('recent.downloads');
    Route::get('my/favorites','myFavorites')->name('my.favorites');

    // Add To Favorites
    Route::get('/add/favorite/{id}', 'addToFavorite')->name('favorite');

    // Revinue
    Route::post('/revenue', 'getRevenue')->name('revenue.by.filter');

});

Route::controller(MelodyController::class)->group(function () {
    Route::get('/my-items', 'index')->name('my.items');
    Route::get('/create-melody', 'create')->name('create.melody');
    Route::post('/upload-zip', 'uploadZip')->name('upload.zip');

    Route::post('/melody/store', 'store')->name('melody.store');

    Route::get('/edit-melody/{id}', action: 'edit')->name('melody.edit');
    Route::post('/update-melody', action: 'update')->name('update.melody');

    Route::get('/get-playing-audio/{id}', action: 'getPlayingMelody')->name('get.playing.audio');
    Route::get('/delete-melody/{id}', action: 'destroy')->name('delete.melody');

    Route::get('/melody/download/{id}', action: 'download')->name('melody.download');
});

Route::controller(PackController::class)->group(function () {
    Route::get('/create-pack', 'create')->name('create.pack');
    Route::post('/pack/store', 'store')->name('pack.store');
    Route::get('/pack/show/{id}', action: 'show')->name('pack.show');
    Route::get('/edit-pack/{id}', action: 'edit')->name('pack.edit');
    Route::post('/update-pack', action: 'update')->name('pack.update');
    Route::delete('/pack-delete/{id}', action: 'destroy')->name('pack.delete');

    Route::get('/pack/download/{id}', action: 'downloadPack')->name('pack.download');
});
Route::controller(PackDemoController::class)->group(function () {
    Route::post('/pack/demo/store', 'store')->name('pack.demo.store');

    Route::get('/get-demo/{id}', action: 'getPlayingDemo')->name('get.demo');
    Route::delete('/delete/demo/{id}', 'destroy')->name('delete.demo');
});

Route::controller(ProfileController::class)->group(function () {
    Route::get('/my-profile', 'index')->name('my.profile');
    Route::get('/edit-profile', 'edit')->name('edit.profile');
    Route::post('/edit-profile', 'update')->name('update.profile');
    Route::post('/change-password', 'ChangePassword')->name('change.password');
    Route::post('/setup-paypal', 'SetupPaypal')->name('setup.paypal');


    Route::post('/set-paypal', 'setPaypal')->name('set.paypal');
    Route::get('/callback-setuppaypal', 'handlePayPalCallback')->name('callback.setuppaypal');

    Route::post('/update-cover-picture', 'UpdateCoverPicture')->name('update.cover.picture');
    Route::post('/update-profile-picture', 'UpdateProfilePicture')->name('update.profile.picture');
    Route::post('/update-file', 'UpdateFile')->name('update.file');

    // Social media
    Route::post('/update-social-media', 'StoreSocialLinks')->name('socialmedia.store');
    Route::get('/edit-social-media/{id}', 'GetSocialLinks')->name('socialmedia.edit');
});

// Browse Melodies
Route::controller(BrowseController::class)->group(function () {
    Route::get('/browse', 'index')->name('browse');
});

// Membership
Route::controller(PaymentController::class)->group(function () {
    Route::get('/membership/{type}', 'membership')->name('membership');
    // Get Membership
    Route::post('/create-subscription', 'storeSubscription')->name('store.subscription')->middleware('auth');
    Route::get('/delete-subscription', 'cancleUserMembership')->name('cancel.subscription')->middleware('auth');
    
    Route::get('/success', 'success')->name('payment.success'); 
});

// MarketPlace Controller
Route::controller(MarketPlaceController::class)->group(function () {
    Route::get('/marketplace', 'index')->name('marketplace');
});

// Cart Controller
Route::controller(CartController::class)->group(function () {
    Route::post('/add-to-cart', 'addToCart')->name('add.to.cart');
    Route::post('/remove-to-cart', 'removeFromCart')->name('remove.to.cart');
    Route::post('/remove-all-from-cart', 'removeAllFromCart')->name('remove.all.from.cart');
});

// Checkout Pack Controller
Route::controller(CheckoutController::class)->group(function () {
    Route::get('/checkout', 'index')->name('checkout');
});

// Producers Controller
Route::controller(ProducerController::class)->group(function () {
    Route::get('/all', 'index')->name('all.producers');
    Route::get('/profile/{username}', 'profile')->name('producers.profile');
});

// Feed Controller
Route::controller(FeedController::class)->group(function () {
    Route::get('/feed', 'index')->name('feed');
});

// Follower Controller
Route::controller(FollowerController::class)->group(function () {
    Route::get('/follow/{id}', 'FollowUser')->name('follow');
    Route::get('/unfollow/{id}', 'UnFollowUser')->name('unfollow');
});

// Paypal Subscriuption Controller
Route::controller(PaypalController::class)->group(function () {
    // Paypal Controller
    Route::get('/paypal/checkout', 'paypalCheckout')->name('paypal.checkout');
    
    Route::get('/success/paypal', 'successTransaction')->name('success.paypal');
    Route::get('/cancel/paypal', 'cancelTransaction')->name('cancel.paypal');
});


// Follower Controller
Route::controller(BuyPackController::class)->group(function () {
    Route::get('/buy-pack/{id}', 'buyPack')->name('buy.pack');
    
    Route::get('/buy-pack/success/paypal', 'successTransaction')->name('buy.pack.success.paypal');
    Route::get('/buy-pack/cancel/paypal', 'cancelTransaction')->name('buy.pack.cancel.paypal');
});


// Search Controller
Route::controller(SearchController::class)->group(function () {
    Route::get('/search', 'index')->name('search');
});
