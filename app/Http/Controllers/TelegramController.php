<?php

namespace App\Http\Controllers;


use App\Telegram\Webhook\Realization;
use App\Telegram\Webhook\Webhook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;

use Illuminate\Support\Facades\Log;

class TelegramController extends Controller
{
    public function webhook(Request $request, Webhook $webhook, Realization $realization)
    {
        $req = json_encode($request->all());
        Log::info($req);
        $path = $realization->take($request);

        if($path)
        {
            try {
                App::make($path)->run();

            }
            catch (\Exception $exception)
            {
                Log::error($exception);
                $webhook->run();
            }
            return true;
        }
        else{
            $webhook->run();
        }

        return true;
    }

    public function index()
    {
        dd(Cache::get('telegram-webhook'));
    }
}
