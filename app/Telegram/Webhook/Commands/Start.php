<?php

namespace App\Telegram\Webhook\Commands;

use App\Facades\Telegram;
use App\Models\Worker;
use App\Telegram\Webhook\Webhook;
use Illuminate\Support\Facades\Http;


class Start extends Webhook
{
    public function run()
    {
        $id = $this->request->input('message')['from']['id'];
        $name = $this->request->input('message')['from']['first_name'];
        $chat_id = $this->request->input('message')['chat']['id'];

        Telegram::message($chat_id,'Доброго дня '.$name.'.')->send();

        //Додаємо користувача до бази якщо його там немає
        $worker = Worker::where('telegram_id' , $id)->first();
        if(!isset($worker)){
            $worker = Worker::create(['telegram_id' => $id,'name' => $name ]);
        }
        //Перевіряємо чи є в базі емейл користувача
        if(!isset($worker->email))
        {
            //якщо немає то запитуємо емейл
             Telegram::message($chat_id,'Введіть свою електронну пошту для підключення до Trello.')->send();
        }else{
            //якщо є то виводимо адресу дошки у трелло
            $lists = Http::get('https://api.trello.com/1/boards/'.env('TRELLO_BOARD_ID').'', [
                'key'   => env('TRELLO_API_KEY'),
                'token' => env('TRELLO_API_TOKEN'),
            ])->json();


             Telegram::message(env('TELEGRAM_CHAT_ID'),'Адреса дошки "'.$lists['name'].'" у Трелло '.$lists['shortUrl'])->send();
        }

    }
}
