<?php

namespace App\Console\Commands;

use App\Repositories\Console\Commands\DispachMailsRepository;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class DispachMails extends Command
{
    CONST SECONDS_TIMEOUT = 2.3;

    private DispachMailsRepository $repository;

    public function __construct(DispachMailsRepository $repository) {
        parent::__construct();
        $this->repository = $repository;
    }

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dispach:mails';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send remaining emails';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        $mails = $this->getMails();
        if(!$mails) {
            $this->info('No records to send');
            return 0;
        }

        foreach($mails as $mail) {
            $this->info("Mail [{$mail->id}] Sending..");

            $result = $this->repository->dispach($mail);

            if($result) {
                $this->info("Mail [{$mail->id}] Sended!");
            } else {
                $this->error("Erro on update mail [{$mail->id}] in table");                
            }

            sleep(self::SECONDS_TIMEOUT);
        }
        $this->info('Mails sendeds');
        return 1;
    }

    private function getMails(): array
    {
        return DB::table('mails')
                ->whereIn('status', ['0', '2'])
                ->get()->toArray();
    }
}
