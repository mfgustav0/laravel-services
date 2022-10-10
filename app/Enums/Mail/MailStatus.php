<?php

namespace App\Enums\Mail;

enum MailStatus: int
{
    case SUCCESS = 0;
    case PENDENT = 1;
    case FAILURE = 2;
}