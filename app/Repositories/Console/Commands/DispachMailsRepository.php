<?php

namespace App\Repositories\Console\Commands;

use App\Mail\Sale\ConfirmedSaleMail;
use App\Mail\Sale\PendentSaleMail;
use App\Mail\Sale\SendedSaleMail;
use App\Exceptions\Mail\InvalidTypeMailException;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;

class DispachMailsRepository
{
	private array $types = [
        'confirmed' => ConfirmedSaleMail::class,
        'pendent' => PendentSaleMail::class,
        'sended' => SendedSaleMail::class
    ];

    public function dispach(object $mail): bool
    {
    	$update = $this->send($mail);

    	$affected = DB::table('mails')
            ->where('id', $mail->id)
            ->update($update);

        return $affected > 0;
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

            Mail::to($client->email)->send(new $model($sale, $client));

            return [
                'observation' => 'email dispached',
                'status' => '1',
                'sended_at' => date('Y-m-d H:i:s'),
                'last_sended_at' => date('Y-m-d H:i:s')
            ];
        } catch(InvalidTypeMailException | \Exception $e) {
            return [
                'observation' => $e->getMessage(),
                'status' => (string)$e->getCode(),
                'last_sended_at' => date('Y-m-d H:i:s')
            ];
        }
    }
}