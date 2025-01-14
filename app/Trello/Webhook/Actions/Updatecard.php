<?php


namespace App\Trello\Webhook\Actions;

use App\Facades\Telegram;
use App\Trello\Webhook\Webhook;
use Illuminate\Support\Facades\Cache;



class Updatecard extends Webhook
{
    public function run()
    {
        $action = $this->request->input('action');

        if (isset($action['data']['listBefore']))
        {
            Cache::forever('webhook-trello',  $this->request->all());
            $board = $action['data']['board']['name'];

            $card = $action['data']['card']['name'];

            $listBefore = $action['data']['listBefore']['name'];

            $listAfter = $action['data']['listAfter']['name'];

            $user_name = $action['memberCreator']['fullName'];

            return Telegram::message(env('TELEGRAM_CHAT_ID'), 'На дошці '.$board.' переміщено карточку "'.$card.'" із колонки '.$listBefore.' у колонку '.$listAfter.' користувачем '.$user_name)->send();
        }
        return false;
    }

}
