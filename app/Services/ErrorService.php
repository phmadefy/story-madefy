<?php


namespace App\Services;

use Illuminate\Support\Facades\Log;

class ErrorService
{
    public static function sendError(\Exception $e)
    {

        Log::info($e);

        if (env('APP_ENV') == 'production') {
            return response()->json('Falha detectada, favor entrar em contato com a StoreFY', 500);
        }

        return response()->json($e, 500);
    }
}
