<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class ContactType extends Enum
{
    const Sender = 'sender';
    const Recipient = 'recipient';
    const Carrier = 'carrier';
}