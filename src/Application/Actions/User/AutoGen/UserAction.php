<?php

declare(strict_types=1);

namespace App\Application\Actions\User\AutoGen;

use App\Domain\User\User;
use App\Domain\User\Repository;

use App\Application\Actions\ActionTwig;
use Psr\Log\LoggerInterface;
use Psr\Container\ContainerInterface;
use Doctrine\ORM\EntityManager;

abstract class UserAction extends ActionTwig
{
    protected Repository $repository;
	protected $model;
	
	public function __construct(LoggerInterface $logger, ContainerInterface $c)
    {
		
		$asset = new Asset();
		$this->assetsSender = $asset->registerTwig();
		
        parent::__construct($logger, $c);
		$this->model = new User($c->get(EntityManager::class), $c);
		$this->repository = $this->model->repositoryInstance();
		
		//your code...
		return $this;
	}
}
