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
        $mailable = new SendedSaleMail($mail->sale, $mail->client);

        $mailable->assertSeeInHtml("Olá {$mail->client->name}! Seu pedido {$mail->sale->id} foi Enviado! Em breve seu pedido chegará em sua casa!");
        foreach($mail->sale->products as $product) {
            $product = (array)$product;
            $mailable->assertSeeInOrderInHtml(array_values($product));
        }
    }
}
