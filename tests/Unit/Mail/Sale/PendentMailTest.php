<?php

namespace Tests\Unit\Mail\Sale;

use App\Mail\Sale\PendentSaleMail;
use App\Models\Mail;
use Tests\TestCase;

class PendentMailTest extends TestCase
{
    public function testMailableContent(): void
    {
        $mail = Mail::factory()->create();
        $mailable = new PendentSaleMail($mail->sale, $mail->client);

        $mailable->assertSeeInHtml("Olá {$mail->client->name}! Seu pedido {$mail->sale->id} foi gerado!");
        foreach($mail->sale->products as $product) {
            $product = (array)$product;
            $mailable->assertSeeInOrderInHtml(array_values($product));
        }
    }
}
