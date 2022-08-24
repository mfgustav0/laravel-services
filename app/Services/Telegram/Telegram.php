<?php

namespace App\Services\Telegram;

use GuzzleHttp\Client;
use App\Exceptions\Telegram\InvalidTokenException;

class Telegram
{
	private string $base_uri = 'https://api.telegram.org/bot';
	private string $bot_name;
	private string $api_key;
	private int $bot_id;

	public function __construct(string $api_key, string $bot_name='')
	{
        preg_match('/(\d+):[\w\-]+/', $api_key, $matches);

        if (!isset($matches[1])) {
            throw new InvalidTokenException('Invalid API KEY defined!');
        }
        $this->bot_id  = (int) $matches[1];
        $this->api_key = $api_key;

        $this->bot_name = $bot_name;
	}

	public function sendMessage(string $chat_id, string $message): array
	{
		$payload = [
			'chat_id' => $chat_id,
			'text' => $message
		];

		return $this->request('POST', 'sendMessage', $payload);
	}

	private function request(string $type, string $end_point, array $payload=[]): array
	{
		$client = new Client([
			'base_uri' => "{$this->base_uri}{$this->api_key}/",
			'timeout' => 60
		]);

		$options = [
			'http_errors' => false,
			'headers' => [
				'Content-Type' => 'application/json'
			],
			'body' => json_encode($payload)
		];
		$response = $client->request($type, $end_point, $options);

		if($response->getStatusCode() != 200) {
			return [
				'success' => false,
				'response' => [
					'code' => $response->getStatusCode(),
					'content' => $response->getBody()->getContents()
				]
			];
		}

		return [
			'success' => true,
			'response' => [
				'code' => $response->getStatusCode(),
				'content' => json_decode($response->getBody()->getContents())
			]
		];
	}
}