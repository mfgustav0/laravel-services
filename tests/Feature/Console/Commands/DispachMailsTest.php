<?php

namespace Tests\Feature\Console\Commands;

use App\Models\Mail;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class DispachMailsTest extends TestCase
{
    use DatabaseTransactions;
    use DatabaseMigrations;

    public function testOutputIfNotExistsRegitersForSend(): void
    {
        $result = Mail::whereIn('status', ['0', '2'])->count();

        $this->artisan('dispach:mails')
            ->assertSuccessful()
            ->expectsOutput('No records to send')
            ->assertExitCode(0);

        $this->assertTrue($result == 0);
    }

    public function testMailsSendeds(): void
    {
        $mails = Mail::factory(5)->state(['status' => '0'])->create();

        $this->artisan('dispach:mails')
            ->assertSuccessful()
            ->expectsOutput('Mails sendeds')
            ->assertExitCode(0);
    }


    public function testMailTypeInvalid(): void
    {
        $mail = Mail::factory()->state([
            'type' => 'invalid',
            'status' => '0'
        ])->create();

        $this->artisan('dispach:mails')
            ->assertSuccessful()
            ->expectsOutput('Mails sendeds')
            ->assertExitCode(0);

        $this->assertDatabaseHas('mails', [
            'id' => $mail->id,
            'observation' => "type of mail not allowed",
            'status' => '2'
        ]);
    }
}
