<?php

declare(strict_types=1);

namespace App\Domain\DomainException;

use App\Domain\DomainException\DomainRecordNotFoundException;

class ActionNotFoundException extends DomainRecordNotFoundException
{
    public $message = 'The requested action does not exist.';
}
