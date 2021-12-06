<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Libraries\CategoryComposer;
use App\Libraries\ProductHotComposer;
use App\Libraries\CartComposer;

class ViewShareServiceProvider extends ServiceProvider
{
    public function register(){

    }
    public function boot(){
        view()->composer(
            'home.*',
            CategoryComposer::class
        );
        view()->composer(
            'home.*',
            ProductHotComposer::class
        );
        view()->composer(
            'home.*',
            CartComposer::class
        );
    }
}
