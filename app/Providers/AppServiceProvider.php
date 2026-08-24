<?php

namespace App\Providers;

use App\Models\Pengaturan;
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
        View::composer(['layouts.app', 'components.*', 'pages.*'], function ($view) {
            $view->with('pengaturanSosmed', [
                'youtube'   => Pengaturan::get('youtube', 'https://www.youtube.com/@OfficialAPPSI'),
                'facebook'  => Pengaturan::get('facebook', 'https://www.facebook.com/info.appsi/'),
                'instagram' => Pengaturan::get('instagram', 'https://www.instagram.com/appsi.or.id/'),
                'twitter'   => Pengaturan::get('twitter', 'https://x.com/appsi_id'),
                'email'     => Pengaturan::get('email', 'info@appsi.or.id'),
                'telepon'   => Pengaturan::get('telepon', '021-2168 4200'),
                'fax'       => Pengaturan::get('fax', '021-2598 4843'),
                'alamat'    => Pengaturan::get('alamat', 'Gedung Nyi Ageng Serang Lt. 4, Jl. HR. Rasuna Said Kav. 22 C, Jakarta Selatan 12940'),
            ]);
        });
    }
}
