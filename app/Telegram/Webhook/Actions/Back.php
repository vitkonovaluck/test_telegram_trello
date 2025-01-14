<?php

namespace App\Telegram\Webhook\Actions;

use App\Facades\Telegram;
use App\Telegram\Webhook\Webhook;

class Back extends Webhook
{
    public function run()
    {
        return Telegram::message(env('TELEGRAM_CHAT_ID'),'До побачення.')->send();
    }
}
