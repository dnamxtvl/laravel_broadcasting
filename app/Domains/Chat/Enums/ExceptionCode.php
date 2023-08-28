<?php

namespace App\Domains\Chat\Enums;

enum ExceptionCode: int
{
    case SEND_MESSAGE_VALIDATION_ERROR = 85628;
    case SEND_MESSAGE_FAIL = 24242;
}
