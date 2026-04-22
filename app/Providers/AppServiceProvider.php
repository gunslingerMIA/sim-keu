<?php

namespace App\Providers;

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
        //
        // Mengambil value dari key 'tahapan_aktif'
        $setting = \App\Models\AppSetting::where('key', 'tahapan_aktif')->first();
        
        // Share ke semua view
        view()->share('tahapanAktif', $setting->value ?? 'murni');
        view()->share('labelTahapan', $setting->label ?? 'APBD Murni');
    }
}
