<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;

class Fonnte
{
    public static function sendWA($target, $message)
    {
        $response = Http::withHeaders([
            'Authorization' => env('FONNTE_API_KEY') 
        ])->post('https://api.fonnte.com/send', [
            'target' => $target,
            'message' => $message,
        ]);

        return $response->json();
    }
}
