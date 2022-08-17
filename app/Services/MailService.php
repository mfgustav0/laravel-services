<?php

namespace App\Services;

use App\Exceptions\Mail\InvalidTypeMailException;
use App\Mail\Sale\ConfirmedSaleMail;
use App\Mail\Sale\PendentSaleMail;
use App\Mail\Sale\SendedSaleMail;
use App\Models\Mail AS MailModel;
use Illuminate\Support\Facades\Mail;

class MailService
{
	private array $types = [
        'confirmed' => ConfirmedSaleMail::class,
        'pendent' => PendentSaleMail::class,
        'sended' => SendedSaleMail::class
    ];

	public function send(MailModel $mail): array
    {
        try {
            $class = $this->getMailable($mail->type);

            $client = json_decode($mail->client);
            $sale = json_decode($mail->sale);

            Mail::to($client->email)->send(new $class($sale, $client));

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

    private function getMailable(string $type): string
    {
		$class = $this->types[$type] ?? null;

		if(!$class && !is_callable($class)) {
		    throw new InvalidTypeMailException("type of mail not allowed", 2);
		}

		return $class;
    }
}