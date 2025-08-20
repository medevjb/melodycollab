<?php

namespace App\Providers;

use App\Models\ArtistType;
use App\Models\Cart;
use App\Models\Country;
use App\Models\DynamicPage;
use App\Models\Favourite;
use App\Models\Genres;
use App\Models\Instrument;
use App\Models\SocialMedia;
use App\Models\SystemSetting;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

        Paginator::useBootstrapFive();

        View::composer('*', function ($view) {
            $setting = SystemSetting::first();
            $socialmedia = SocialMedia::get();
            $dynamicPage = DynamicPage::where('status', 1)->get();
            $countries = Country::orderBy('order', 'asc')->get();
            $carts = Cart::where('user_id', auth()->check() ? auth()->user()->id : null)->with('items')->first();

            // Fetch active genres, instruments, and artist types
            $genrises = Genres::where('status', 'active')->orderBy('order', 'asc')->get();
            $instruments = Instrument::where('status', 'active')->orderBy('order', 'asc')->get();
            $artiseTypes = ArtistType::where('status', 'active')->orderBy('order', 'asc')->get();

            // Fet My Fvorites Ids
            $fvrts = Favourite::where('user_id', auth()->check() ? auth()->user()->id : null)
                                ->with('items')
                                ->pluck('melody_id')
                                ->toArray();

            $view->with('genrises', $genrises);
            $view->with('instruments', $instruments);
            $view->with('artiseTypes', $artiseTypes);
            $view->with('fvrts', $fvrts);

            $view->with('setting', $setting);
            $view->with('socialmedia', $socialmedia);
            $view->with('dynamicPages', $dynamicPage);
            $view->with('countries', $countries);
            $view->with('carts', $carts);
        });
    }
}
