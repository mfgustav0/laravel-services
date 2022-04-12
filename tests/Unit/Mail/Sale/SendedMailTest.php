<?php

namespace Tests\Unit\Mail\Sale;

use App\Mail\Sale\SendedSaleMail;
use App\Models\Mail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SendedMailTest extends TestCase
{
    use RefreshDatabase;

    public function testMailableContent(): void
    {
        $mail = Mail::factory()->create();
        $client = json_decode($mail->client);
        $sale = json_decode($mail->sale);

        $mailable = new SendedSaleMail($sale, $client);

        $mailable->assertSeeInHtml("Olá {$client->name}! Seu pedido {$sale->id} foi Enviado! Em breve seu pedido chegará em sua casa!");
        foreach($sale->products as $product) {
            $product = (array)$product;
            $mailable->assertSeeInOrderInHtml(array_values($product));
        }
    }
}
