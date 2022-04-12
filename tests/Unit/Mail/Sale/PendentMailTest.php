<?php

namespace Tests\Unit\Mail\Sale;

use App\Mail\Sale\PendentSaleMail;
use App\Models\Mail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PendentMailTest extends TestCase
{
    use RefreshDatabase;

    public function testMailableContent(): void
    {
        $mail = Mail::factory()->create();
        $client = json_decode($mail->client);
        $sale = json_decode($mail->sale);

        $mailable = new PendentSaleMail($sale, $client);

        $mailable->assertSeeInHtml("Olá {$client->name}! Seu pedido {$sale->id} foi gerado!");
        foreach($sale->products as $product) {
            $product = (array)$product;
            $mailable->assertSeeInOrderInHtml(array_values($product));
        }
    }
}
