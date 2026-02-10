<?php

namespace App\Providers;

use App\Models\Menu;
use App\Models\Setting;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Share settings and menus with all views
        View::composer('*', function ($view) {
            // Cache settings for the request lifecycle
            static $siteSettings = null;
            static $headerMenus = null;
            static $footerMenus = null;

            if ($siteSettings === null) {
                try {
                    if (Schema::hasTable('settings')) {
                        $siteSettings = Setting::pluck('value', 'key')->toArray();
                    } else {
                        $siteSettings = [];
                    }
                } catch (\Exception $e) {
                    $siteSettings = [];
                }
            }

            if ($headerMenus === null) {
                try {
                    if (Schema::hasTable('menus')) {
                        $headerMenus = Menu::where('location', 'header')
                            ->whereNull('parent_id')
                            ->where('is_active', true)
                            ->orderBy('sort_order')
                            ->with(['children' => function ($q) {
                                $q->where('is_active', true)->orderBy('sort_order');
                            }])
                            ->get();

                        $footerMenus = Menu::where('location', 'footer')
                            ->whereNull('parent_id')
                            ->where('is_active', true)
                            ->orderBy('sort_order')
                            ->with(['children' => function ($q) {
                                $q->where('is_active', true)->orderBy('sort_order');
                            }])
                            ->get();
                    } else {
                        $headerMenus = collect();
                        $footerMenus = collect();
                    }
                } catch (\Exception $e) {
                    $headerMenus = collect();
                    $footerMenus = collect();
                }
            }

            $view->with('siteSettings', $siteSettings);
            $view->with('siteHeaderMenus', $headerMenus);
            $view->with('siteFooterMenus', $footerMenus);
        });
    }
}
