<?php

namespace App\Telegram\Webhook;

use App\Telegram\Webhook\Actions\Back;
use App\Telegram\Webhook\Actions\Invite;
use App\Telegram\Webhook\Commands\Email;
use App\Telegram\Webhook\Commands\Start;
use Illuminate\Http\Request;

class Realization
{
    protected const Commands = [
        '/start' => Start::class,
        'email'  => Email::class,
        'Back'   => Back::class,
        'Invite' => Invite::class
    ];

    public function take(Request $request)
    {

        if(isset($request->input('message')['entities'][0]['type']))
        {
            if($request->input('message')['entities'][0]['type'] == 'bot_command')
            {
                $command_name = explode(' ', strtolower($request->input('message')['text']))[0];
                return self::Commands[$command_name];
            }
            if($request->input('message')['entities'][0]['type'] == 'email')
            {
                $command_name = $request->input('message')['entities'][0]['type'];
                return self::Commands[$command_name];
            }
        }
        if($request->input('callback_query'))
        {
            $data = json_decode($request->input('callback_query')['data']);
                return self::Commands[$data->action];
        }

        return false;
    }
}
