<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Response;

class ResponseServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Response::macro('error', function ($message = null, $data = null) {
            $response = [
                "error" => true,
                "message" => $message ?: "Fix this Error",
                "data" => $data
            ];
            return response()->json($response, 200);
        });
        Response::macro('success', function ($message = null, $data = null) {
            $response = [
                "error" => false,
                "message" => $message ?: "Success",
                "data" => $data
            ];
            return response()->json($response, 200);
        });
    }
}
