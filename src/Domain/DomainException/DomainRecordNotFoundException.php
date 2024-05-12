<?php

declare(strict_types=1);

namespace App\Domain\DomainException;

class DomainRecordNotFoundException extends DomainException
{
	public $message = 'The record you requested does not exist.';

	public function __construct($msg = null) {
		$msg && ($this->message = $msg);
	}
}
