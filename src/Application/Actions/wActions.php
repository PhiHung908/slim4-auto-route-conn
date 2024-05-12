<?php

declare(strict_types=1);

namespace App\Application\Actions;

use App\Application\Actions\Action;
use Psr\Log\LoggerInterface;
use Psr\Container\ContainerInterface;
use Doctrine\ORM\EntityManager;

abstract class wActions extends ActionTwig
{
    protected Repository $repository;
	protected $model;
	
	public function __construct(?LoggerInterface $logger = null, ?ContainerInterface $c = null)
    {
        parent::__construct($logger);
		//your code...
		return $this;
	}
}
