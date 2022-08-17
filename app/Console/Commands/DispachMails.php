<?php

namespace App\Console\Commands;

use App\Models\Mail;
use App\Services\MailService;
use Illuminate\Console\Command;

class DispachMails extends Command
{
    CONST SECONDS_TIMEOUT = 2.3;

    protected $signature = 'dispach:mails';

    protected $description = 'Send remaining emails';

    public function handle(MailService $service, Mail $model): int
    {
        $mails = $model->pendents();
        if(!$mails->count()) {
            $this->info('No records to send');
            return self::SUCCESS;
        }

        $mails->each(function(Mail $mail) use($service) {
            $this->info("Mail [{$mail->id}] Sending..");

            $result = $service->send($mail);

            $mail->update($result);

            $this->info("Mail [{$mail->id}] Sended!");

            sleep(self::SECONDS_TIMEOUT);
        });

        $this->info('Mails sendeds');
        return self::SUCCESS;
    }
}
