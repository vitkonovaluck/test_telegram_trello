<?php

namespace App\Http\Controllers;

use App\Trello\Webhook\Realization;
use App\Trello\Webhook\Webhook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class TrelloController extends Controller
{
    public function index()
    {
        dd(Cache::get('webhook-trello'));

    }

    public function webhook(Request $request, Webhook $webhook, Realization $realization)
    {
//        Cache::forever('webhook-trello', $request->all());
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

    public function setwebhook()
    {

    }

}
