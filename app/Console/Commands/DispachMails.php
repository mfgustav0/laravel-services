<?php

namespace App\Console\Commands;

use App\Exceptions\Mail\InvalidTypeMailException;
use App\Mail\Sale\ConfirmedSaleMail;
use App\Mail\Sale\PendentSaleMail;
use App\Mail\Sale\SendedSaleMail;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class DispachMails extends Command
{
    CONST SECONDS_TIMEOUT = 2.3;

    private array $types = [
        'confirmed' => ConfirmedSaleMail::class,
        'pendent' => PendentSaleMail::class,
        'sended' => SendedSaleMail::class
    ];
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dispach:mails';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send remaining emails';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        $mails = $this->getMails();
        if(!$mails) {
            $this->info('No records to send');
            return 0;
        }

        foreach($mails as $mail) {
            $this->info("Mail [{$mail->id}] Sending..");
            $update = $this->send($mail);

            $affected = DB::table('mails')
                ->where('id', $mail->id)
                ->update($update);

            if($affected < 0) {
                $this->error("Erro on update mail [{$mail->id}] in table");
            }
            $this->info("Mail [{$mail->id}] Sended!");
            sleep(self::SECONDS_TIMEOUT);
        }
        $this->info('Mails sendeds');
        return 1;
    }

    private function getMails(): array
    {
        return DB::table('mails')
                ->whereIn('status', ['0', '2'])
                ->get()->toArray();
    }

    private function send(object $mail): array
    {
        try {
            $model = $this->types[$mail->type] ?? null;

            if(!$model && !is_callable($model)) {
                throw new InvalidTypeMailException("type of mail [{$mail->id}] not allowed", 2);
            }

            $client = json_decode($mail->client);
            $sale = json_decode($mail->sale);

            Mail::to('testesemail110@gmail.com')->send(new $model($sale, $client));

            return [
                'observation' => 'email dispached',
                'status' => '1',
                'sended_at' => date('Y-m-d H:i:s'),
                'last_sended_at' => date('Y-m-d H:i:s')
            ];
        } catch(InvalidTypeMailException | \Exception $e) {
            $this->info($e->getMessage());

            return [
                'observation' => $e->getMessage(),
                'status' => (string)$e->getCode(),
                'last_sended_at' => date('Y-m-d H:i:s')
            ];
        }
    }
}
