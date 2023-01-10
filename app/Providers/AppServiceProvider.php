<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $supporters = array(
            array("src" => "images/supporters/AbraSilver.png", "url" => "https://test.com"),
            array("src" => "images/supporters/DollyVarden.png", "url" => "https://test.com"),
            array("src" => "images/supporters/Eloro.png", "url" => "https://test.com"),
            array("src" => "images/supporters/Kinesis.png", "url" => "https://test.com"),
            array("src" => "images/supporters/KuyaSilver.png", "url" => "https://test.com"),
            array("src" => "images/supporters/SilverGoldBull.png", "url" => "https://test.com"),
            array("src" => "images/supporters/SprottMoney.png", "url" => "https://test.com"),
        );
        $contacts = array(
            array("name" => "Jim Lewis", "thumbnail" => "images/avatars/Jim.png", "contact_link" => "https://www.linkedin.com/in/wallstreetsilver/"),
            array("name" => "Ivan Bayoukhi", "thumbnail" => "images/avatars/Ivan.png", "contact_link" => "https://www.linkedin.com/in/ivanbayoukhi/"),
        );
        $current_nav_tab = '';
        View::share('supporters', $supporters);
        View::share('contacts', $contacts);
        View::share('current_nav_tab', $current_nav_tab);
    }
}
