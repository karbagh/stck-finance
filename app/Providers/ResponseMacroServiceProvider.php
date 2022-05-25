<?php

namespace App\Providers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\ServiceProvider;

class ResponseMacroServiceProvider extends ServiceProvider
{
    public function boot()
    {
        JsonResponse::macro('message', function ($message) {
            return [
                'errors'  => false,
                'message' => $message,
            ];
        });
    }
}
