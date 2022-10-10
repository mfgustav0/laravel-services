<?php

namespace App\Console\Commands;

use App\Models\Mail;
use App\Services\MailService;
use Illuminate\Console\Command;

class DispachMails extends Command
{
    CONST SECONDS_TIMEOUT = 2.3;

    protected $signature = 'dispach:mails';

    protected $description = 'Send remaining email`s';

    public function handle(MailService $service, Mail $model): int
    {
        $mails = $model->pendents();
        if(!$mails->count()) {
            $this->warn('No records to send');
            return self::SUCCESS;
        }

        $mails->each(fn(Mail $mail) => $this->send($mail, $service));

        $this->info('Mails sendeds');
        return self::SUCCESS;
    }

    private function send(Mail $mail, MailService $service): void
    {
        $this->warn("Mail [{$mail->id}] Sending..");

        $result = $service->send($mail);

        $mail->update($result);

        $this->info("Mail [{$mail->id}] Sended!");

        sleep(self::SECONDS_TIMEOUT);
    }
}
