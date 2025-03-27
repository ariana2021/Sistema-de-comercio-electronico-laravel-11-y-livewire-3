<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Business;
use App\Models\Category;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        View::composer(['layouts.partials.header', 'layouts.partials.footer'], function ($view) {
            $business = Business::first();
            $categories = Category::all();

            $view->with([
                'business' => $business,
                'categories' => $categories
            ]);
        });
    }
}
