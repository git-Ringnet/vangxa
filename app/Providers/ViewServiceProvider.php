<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\UserInteraction;

class ViewServiceProvider extends ServiceProvider
{
    public function boot()
    {
        View::composer('layouts.main', function ($view) {
            $view->with('topContributors', UserInteraction::getTopContributors(10));
        });
    }
} 