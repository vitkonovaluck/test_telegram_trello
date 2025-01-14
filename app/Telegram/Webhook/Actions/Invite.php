<?php


namespace App\Telegram\Webhook\Actions;


use App\Facades\Telegram;
use App\Models\Worker;
use App\Telegram\Webhook\Webhook;
use Illuminate\Support\Facades\Http;

class Invite extends Webhook
{
    public function run()
    {
        $w_id =$this->request->input('callback_query')['from']['id'];
        $chat_id =$this->request->input('callback_query')['message']['chat']['id'];
        $worker = Worker::where('telegram_id',$w_id)->first();
        //Надсилаємо запит на приэднання до дошки трелло
        $response = Http::put('https://api.trello.com/1/boards/'.env('TRELLO_BOARD_ID').'/members', [
            'email'  => $worker->email,
            'key'   => env('TRELLO_API_KEY'),
            'token' => env('TRELLO_API_TOKEN'),
        ]);

        $lists = Http::get('https://api.trello.com/1/boards/'.env('TRELLO_BOARD_ID').'', [
            'key'   => env('TRELLO_API_KEY'),
            'token' => env('TRELLO_API_TOKEN'),
        ])->json();

        if($response->status() == 200) {
            Telegram::message($chat_id,' Вас приєднано до дошки "'.$lists['name'].'" у Трелло.')->send();

        }elseif($response->status() == 400) {
            Telegram::message($chat_id,'Помилка  '.$response['message'])->send();
            Telegram::message($chat_id,'Введіть свою електронну пошту для підключення до Trello.')->send();
            return false;
        }


        return  Telegram::message($chat_id,'Адреса дошки "'.$lists['name'].'" у Трелло '.$lists['shortUrl'])->send();

    }

}
