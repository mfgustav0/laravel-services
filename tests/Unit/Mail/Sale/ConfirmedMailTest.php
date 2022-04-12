<?php

namespace Tests\Unit\Mail\Sale;

use App\Mail\Sale\ConfirmedSaleMail;
use App\Models\Mail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ConfirmedMailTest extends TestCase
{
    use RefreshDatabase;

    public function testMailableContent(): void
    {
        $mail = Mail::factory()->create();
        $client = json_decode($mail->client);
        $sale = json_decode($mail->sale);

        $mailable = new ConfirmedSaleMail($sale, $client);

        $mailable->assertSeeInHtml("Olá {$client->name}! Seu pedido {$sale->id} foi confirmado! Em breve seu pedido será enviado");
        foreach($sale->products as $product) {
            $product = (array)$product;
            $mailable->assertSeeInOrderInHtml(array_values($product));
        }
    }
}
