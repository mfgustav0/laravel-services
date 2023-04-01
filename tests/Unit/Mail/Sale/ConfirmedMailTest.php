<?php

namespace Tests\Unit\Mail\Sale;

use App\Mail\Sale\ConfirmedSaleMail;
use App\Models\Mail;
use Tests\TestCase;

class ConfirmedMailTest extends TestCase
{
    public function testMailableContent(): void
    {
        $mail = Mail::factory()->create();
        $mailable = new ConfirmedSaleMail($mail->sale, $mail->client);

        $mailable->assertSeeInHtml("Olá {$mail->client->name}! Seu pedido {$mail->sale->id} foi confirmado! Em breve seu pedido será enviado");
        foreach($mail->sale->products as $product) {
            $product = (array)$product;
            $mailable->assertSeeInOrderInHtml(array_values($product));
        }
    }
}
