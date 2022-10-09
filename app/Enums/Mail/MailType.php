<?php

namespace App\Enums\Mail;

use App\Mail\Sale\ConfirmedSaleMail;
use App\Mail\Sale\PendentSaleMail;
use App\Mail\Sale\SendedSaleMail;

enum MailType: string
{
    case CONFIRMED = ConfirmedSaleMail::class;
    case PENDENT = PendentSaleMail::class;
    case SENDED = SendedSaleMail::class;
}