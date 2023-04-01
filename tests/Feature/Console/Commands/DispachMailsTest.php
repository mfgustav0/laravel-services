<?php

namespace Tests\Feature\Console\Commands;

use App\Enums\Mail\MailStatus;
use App\Models\Mail;
use Tests\TestCase;

class DispachMailsTest extends TestCase
{
    public function testOutputIfNotExistsRegitersForSend(): void
    {
        $result = (new Mail())->pendents()->count();

        $this->artisan('dispach:mails')
            ->assertSuccessful()
            ->expectsOutput('No records to send')
            ->assertExitCode(0);

        $this->assertTrue($result == 0);
    }

    public function testMailsSendeds(): void
    {
        $mails = Mail::factory(5)->state(['status' => MailStatus::PENDENT])->create();

        $this->artisan('dispach:mails')
            ->assertSuccessful()
            ->expectsOutput('Mails sendeds')
            ->assertExitCode(0);
    }

    public function testMailTypeInvalid(): void
    {
        $mail = Mail::factory()->state([
            'type' => 'invalid',
            'status' => MailStatus::PENDENT
        ])->create();

        $this->artisan('dispach:mails')
            ->assertSuccessful()
            ->expectsOutput('Mails sendeds')
            ->assertExitCode(0);

        $this->assertDatabaseHas('mails', [
            'id' => $mail->id,
            'observation' => "type of mail not allowed",
            'status' => MailStatus::FAILURE
        ]);
    }
}
