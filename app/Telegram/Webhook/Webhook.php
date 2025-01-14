<?php

namespace App\Telegram\Webhook;

use App\Facades\Telegram;
use Illuminate\Http\Request;


class Webhook
{
    protected Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function run()
    {
        return  Telegram::message(env('TELEGRAM_CHAT_ID'),'Не вдалося опрацювати повідомлення')->send();
    }
}
