<?php

namespace App\Console\Commands;

use App\Facades\Telegram;
use App\Telegram\Helpers\Button;
use Illuminate\Console\Command;

class SendMessageCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'telegram:send {Message}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Button::buttons('Звіт','Report',['yes' => 1], 1);
        Telegram::button(env('TELEGRAM_CHAT_ID'),$this->argument('Message'),Button::$buttons)->send();

    }
}
