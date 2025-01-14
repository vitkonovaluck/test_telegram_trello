<?php

namespace App\Console\Commands;

use App\Facades\Telegram;
use Illuminate\Console\Command;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;

class SetupCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:setup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Початкова настроюваеея програми';

    /**
     * Execute the console command.
     */
    public function handle()
    {

        $response = Http::withHeaders([
            'Accept' => 'application/json',
        ])->post('https://api.trello.com/1/tokens/'.env('TRELLO_API_TOKEN').'/webhooks/', [
            'key'         => env('TRELLO_API_KEY'),
            'description' => 'test Webhook'.env('TRELLO_BOARD_ID'),
            'callbackURL' => env('APP_URL') . '/api/trello_webhook',
            'idModel'     => env('TRELLO_BOARD_ID'),
        ]);


        if ($response->status() !== Response::HTTP_OK) {
            $this->error('Webhook не створено!');

            return Command::FAILURE;
        }

        $this->info('Webhook  Trello створено!');

        $lists = Http::get('https://api.trello.com/1/boards/'.env('TRELLO_BOARD_ID').'/lists', [
            'key'   => env('TRELLO_API_KEY'),
            'token' => env('TRELLO_API_TOKEN'),
        ]);
        $list = json_decode($lists);

        $name = 'InProgress';

        if (!str_contains($list,$name)) {
            //при відсутності  додаємо
            $response = Http::withHeaders([
                'Accept' => 'application/json'
            ])->post('https://api.trello.com/1/boards/' . env('TRELLO_BOARD_ID') . '/lists', [
                'name' => $name,
                'key' => env('TRELLO_API_KEY'),
                'token' => env('TRELLO_API_TOKEN'),
            ]);

            if ($response->status() !== Response::HTTP_OK) {
                $this->error('Список ' . $name . ' не створено');

                return Command::FAILURE;
            }
            $this->info('Список ' . $name . ' створено');
        }

            $name = 'Done';

        if (!str_contains($list,$name)) {
            //при відсутності  додаємо
            $response = Http::withHeaders([
                'Accept' => 'application/json'
            ])->post('https://api.trello.com/1/boards/' . env('TRELLO_BOARD_ID') . '/lists', [
                'name' => $name,
                'key' => env('TRELLO_API_KEY'),
                'token' => env('TRELLO_API_TOKEN'),
            ]);

            if ($response->status() !== Response::HTTP_OK) {
                $this->error('Список ' . $name . ' не створено');

                return Command::FAILURE;
            }
            $this->info('Список ' . $name . ' створено');
        }

        $response = Http::withHeaders([
            'Accept' => 'application/json'
        ])->post('https://api.telegram.org/bot' . env('TELEGRAM_BOT_TOKEN') . '/setWebhook', [
            'url' => env('APP_URL') . '/api/telegram_webhook',
        ])->json();

        if (!$response['ok']) {
            $this->warm('Webhook Телеграм бота не створено');

            return Command::FAILURE;
        }

        $this->info('Webhook Телеграм бота створено');

        Telegram::message(env('TELEGRAM_CHAT_ID'),'Тестове повідомлення. ')->send();

        return Command::SUCCESS;
    }
}
