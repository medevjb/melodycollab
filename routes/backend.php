<?php

use App\Http\Controllers\Web\Backend\AdminController;
use App\Http\Controllers\Web\Backend\ArtistTypeController;
use App\Http\Controllers\Web\Backend\CountryController;
use App\Http\Controllers\Web\Backend\DashboardController;
use App\Http\Controllers\Web\Backend\Email\EmailController;
use App\Http\Controllers\Web\Backend\Email\NewsletterController;
use App\Http\Controllers\Web\Backend\Email\NotificationController;
use App\Http\Controllers\Web\Backend\FAQController;
use App\Http\Controllers\Web\Backend\GenresController;
use App\Http\Controllers\Web\Backend\InstrumentController;
use App\Http\Controllers\Web\Backend\Melody\MelodiesController;
use App\Http\Controllers\Web\Backend\Membership\MembershipController;
use App\Http\Controllers\Web\Backend\Packs\PacksController;
use App\Http\Controllers\Web\Backend\Settings\DynamicPageController;
use App\Http\Controllers\Web\Backend\Settings\GoogleAnalyticsController;
use App\Http\Controllers\Web\Backend\Settings\MailSettingController;
use App\Http\Controllers\Web\Backend\Settings\ProfileController;
use App\Http\Controllers\Web\Backend\Settings\SocialMediaController;
use App\Http\Controllers\Web\Backend\Settings\StripeSettingController;
use App\Http\Controllers\Web\Backend\Settings\SystemSettingController;
use App\Http\Controllers\Web\Backend\UserController;
use Illuminate\Support\Facades\Route;

//! Route for DashboardController
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

//! Route for ProfileController
Route::get('/profile', [ProfileController::class, 'showProfile'])->name('profile.setting');
Route::post('/update-profile', [ProfileController::class, 'UpdateProfile'])->name('update.profile');
Route::post('/update-profile-password', [ProfileController::class, 'UpdatePassword'])->name('update.Password');
Route::post('/update-profile-picture', [ProfileController::class, 'UpdateProfilePicture'])->name('update.profile.picture');
Route::post('/update-cover-picture', [ProfileController::class, 'UpdateCoverPicture'])->name('update.cover.picture');

//! Route for SystemSettingController
Route::get('/system-setting', [SystemSettingController::class, 'index'])->name('system.index');
Route::post('/system-setting', [SystemSettingController::class, 'update'])->name('system.update');
Route::get('/pixel-setting', [SystemSettingController::class, 'pixel'])->name('pixel.index');
Route::post('/pixel-setting', [SystemSettingController::class, 'pixelStotre'])->name('pixel.store');
Route::post('/commition-setting', [SystemSettingController::class, 'commitionStotre'])->name('commition.store');

//! Route for MailSettingController
Route::get('/mail-setting', [MailSettingController::class, 'index'])->name('mail.setting');
Route::post('/mail-setting', [MailSettingController::class, 'update'])->name('mail.update');

//! Route for SocialMediaController
Route::get('/social-media', [SocialMediaController::class, 'index'])->name('social.index');
Route::post('/social-media', [SocialMediaController::class, 'update'])->name('social.update');
Route::delete('/social-media/{id}', [SocialMediaController::class, 'destroy'])->name('social.delete');

//! Route for DynamicpageController
Route::controller(DynamicPageController::class)->group(function () {
    Route::get('/dynamic-page', 'index')->name('dynamic_page.index');
    Route::get('/dynamic-page/create', 'create')->name('dynamic_page.create');
    Route::post('/dynamic-page/store', 'store')->name('dynamic_page.store');
    Route::get('/dynamic-page/edit/{id}', 'edit')->name('dynamic_page.edit');
    Route::post('/dynamic-page/update/{id}', 'update')->name('dynamic_page.update');
    Route::get('/dynamic-page/status/{id}', 'status')->name('dynamic_page.status');
    Route::delete('/dynamic-page/destroy/{id}', 'destroy')->name('dynamic_page.destroy');
});

//! Route for StripeSettingController
Route::get('/stripe-setting', [StripeSettingController::class, 'index'])->name('stripe.index');
Route::post('/stripe-setting', [StripeSettingController::class, 'update'])->name('stripe.update');

//! Route for GoogleAnalyticsController
Route::get('/analytics-setting', [GoogleAnalyticsController::class, 'index'])->name('analytics.index');
Route::post('/analytics-setting', [GoogleAnalyticsController::class, 'update'])->name('analytics.update');

//! Route for Calendar
Route::view('/calender', 'backend.layouts.settings.calendar')->name('calendar');

//! Route for FAQController Backend
Route::controller(FAQController::class)->group(function () {
    Route::get('/faq/', 'index')->name('faq.index');
    Route::get('/faq/create', 'create')->name('faq.create');
    Route::post('/faq/store', 'store')->name('faq.store');
    Route::get('/faq/edit/{id}', 'edit')->name('faq.edit');
    Route::put('/faq/update/{id}', 'update')->name('faq.update');
    Route::get('/faq/status/{id}', 'status')->name('faq.status');
    Route::delete('/faq/destroy/{id}', 'destroy')->name('faq.destroy');
});

//! Route for Genres Backend
Route::controller(GenresController::class)->group(function () {
    Route::get('/genres', 'index')->name('genres.index');
    Route::post('/genres/create', 'createOrUpdate')->name('create.update.genres');
    Route::get('/genres/{id}', 'getGenres')->name('genres.get');
    Route::get('/genres/status/{id}', 'status')->name('genres.status');
    Route::delete('/genres/destroy/{id}', 'destroy')->name('genres.destroy');

    Route::post('/genres/reorder', 'reorder')->name('genres.rendaring');
});

//! Route for Genres Backend
Route::controller(InstrumentController::class)->group(function () {
    Route::get('/instrument', 'index')->name('instrument.index');
    Route::post('/instrument/create', 'createOrUpdate')->name('create.update.instrument');
    Route::get('/instrument/{id}', 'getinstrument')->name('instrument.get');
    Route::get('/instrument/status/{id}', 'status')->name('instrument.status');
    Route::delete('/instrument/destroy/{id}', 'destroy')->name('instrument.destroy');
    Route::post('/instrument/reorder', 'reorder')->name('instrument.rendaring');
});
//! Route for Artist Type Backend
Route::controller(ArtistTypeController::class)->group(function () {
    Route::get('/artist/type', 'index')->name('artist.type.index');
    Route::post('/artist/type/create', 'createOrUpdate')->name('create.update.artist.type');
    Route::get('/artist/type/{id}', 'getArtistType')->name('artist.type.get');
    Route::get('/artist/type/status/{id}', 'status')->name('artist.type.status');
    Route::delete('/artist/type/destroy/{id}', 'destroy')->name('artist.type.destroy');
    Route::post('/artist/type/reorder', 'reorder')->name('artist.type.rendaring');
});

//! Route for Emails
Route::controller(EmailController::class)->group(function () {
    Route::get('/email/edit/{slug}', 'edit')->name('email.edit');
    Route::put('/email/update', 'update')->name('email.update');
});

//! Route for Newsletter
Route::controller(NewsletterController::class)->group(function () {
    Route::get('/newsletter/{slug}', 'index')->name('newsletter');
    Route::post('/newsletter/sends', 'sendMail')->name('newsletter.sends');

});

//! Route for Notification
Route::controller(NotificationController::class)->group(function () {
    Route::get('/notification', 'index')->name('notification');
    Route::post('/notification/send', 'MailSend')->name('notification.send');
});

//! Route for membership
Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    Route::controller(MembershipController::class)->group(function () {
        Route::get('/user-membership', 'index')->name('user.membership');
        Route::post('/membership/toggle/status', 'status')->name('membership.toggleStatus');
        Route::get('/membership/create', 'create')->name('membership.create');
        Route::post('/membership/store', 'store')->name('membership.store');
    });

});
//! Route for Admin
Route::prefix('admin')->middleware(['auth', 'admin'])->name('admin.')->group(function () {
    Route::controller(AdminController::class)->group(function () {
        Route::get('/index', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/store', 'store')->name('store');
    });
});

//! Route for Melody
Route::controller(MelodiesController::class)->group(function () {
    Route::get('/melody', 'index')->name('melody.index');
    // Route::post('/melody/update-status','updateStatus')->name('melody.updateStatus');
    Route::post('/melody/toggle/status', 'status')->name('melody.toggleStatus');
    Route::get('/melody/download/file/{id}', 'melodydownloadFile')->name('melody.download.file');
});

//! Route for packs
Route::controller(PacksController::class)->group(function () {
    Route::get('/packs', 'index')->name('packs.index');
    Route::post('/pack/toggle/status', 'toggleStatus')->name('pack.toggleStatus');
    Route::get('/download/file/{id}', 'downloadFile')->name('download.file');
});
//! Route for Country
Route::controller(CountryController::class)->group(function () {
    Route::get('/country', 'index')->name('country.index');
    Route::post('/country/create', 'createOrUpdate')->name('create.update.country');
    Route::get('/country/{id}', 'getcountry')->name('country.get');
    Route::get('/country/status/{id}', 'status')->name('country.status');
    Route::delete('/country/destroy/{id}', 'destroy')->name('country.destroy');

    Route::post('/country/reorder', 'reorder')->name('country.rendaring');
});

//! Route for User List
Route::controller(UserController::class)->group(function () {
    Route::get('/user/list', 'index')->name('user.index');
    Route::delete('/user/destroy/{id}', 'destroy')->name('user.destroy');
    
});