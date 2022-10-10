<?php

namespace App\Console\Commands\Telegram;

use App\Services\Telegram\Telegram;
use Illuminate\Console\Command;

class Message extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'telegram:message {message="hello world"}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send telegram message';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(Telegram $telegram)
    {
        $message = $this->argument('message');
        $result = $telegram->sendMessage(config('telegram.chat-log'), $message);
        dd($result);
        return 0;
    }
}
