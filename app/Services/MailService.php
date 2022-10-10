<?php

namespace App\Services;

use App\Enums\Mail\MailType;
use App\Exceptions\Mail\InvalidTypeMailException;
use App\Models\Mail AS MailModel;
use Illuminate\Support\Facades\Mail;

class MailService
{
	public function send(MailModel $mail): array
    {
        try {
            $class = $this->getMailable($mail->type);

            Mail::to($client->email)->send(new $class($mail->sale, $mail->client));

            return [
                'observation' => 'email dispached',
                'status' => MailType::SUCCESS,
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
		$class = MailType::tryFrom($type) ?? null;
		if(!$class && !is_callable($class)) {
		    throw new InvalidTypeMailException('type of mail not allowed', 2);
		}

		return $class;
    }
}