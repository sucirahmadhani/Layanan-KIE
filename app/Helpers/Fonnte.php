<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;

class Fonnte
{
    public static function sendWA($target, $message)
    {
        $token = config('services.fonnte.token');

        $response = Http::timeout(30)->withHeaders([
            'Authorization' => $token
        ])->post('https://api.fonnte.com/send', [
            'target' => $target,
            'message' => $message,
        ]);

        return $response->json();
    }
}
