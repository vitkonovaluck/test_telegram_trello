<?php

namespace App\Telegram\Webhook\Commands;

use App\Facades\Telegram;
use App\Models\Worker;
use App\Telegram\Helpers\Button;
use App\Telegram\Webhook\Webhook;


class Trelloadd extends Webhook
{
    public function run()
    {
//        $id = $this->request->input('message')['from']['id'];
//        $email = $this->request->input('message')['text'];
//        $chat_id = $this->request->input('message')['chat']['id'];
//
//        $worker = Worker::where('telegram_id', $id)->first();
//        $worker->trello_id = 0;
//        $worker->save();
//
//        Button::add('Так','Invite', ['yes' => 1], 1);
//        Button::add('Ні','Back',  ['no' => 1], 1);
//
//        return Telegram::buttons($chat_id,'Додати Вас до дошки у Трелло?',Button::$buttons)->send();

    }
}
