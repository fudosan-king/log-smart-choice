<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use TCG\Voyager\Facades\Voyager;
use App\Actions\Groups;

class EstateServiceProvider extends ServiceProvider
{
    public function register()
    {
        
    }
    
    public function boot() {
        Voyager::addAction(Groups::class);
    }
}