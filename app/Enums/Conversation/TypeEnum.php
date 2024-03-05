<?php

namespace App\Enums\Conversation;

enum TypeEnum: int
{
    case SINGLE = 0;
    case MULTIPLE = 1;
    case DOES_NOT_HAVE_CONVERSATION = 2;
}
