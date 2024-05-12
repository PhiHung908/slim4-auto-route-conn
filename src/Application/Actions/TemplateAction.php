<?php

declare(strict_types=1);

namespace App\Application\Actions\#TPL_PRODUCT#\AutoGen;

use App\Domain\#TPL_PRODUCT#\#TPL_PRODUCT#;
use App\Domain\#TPL_PRODUCT#\Repository;

use App\Base\ActionTwig;

use Psr\Log\LoggerInterface;
use Psr\Container\ContainerInterface;
use Doctrine\ORM\EntityManager;

abstract class #TPL_PRODUCT#Action extends ActionTwig
{
    protected Repository $repository;
	protected $model;
	
	public function __construct(LoggerInterface $logger, ContainerInterface $c)
    {
		
		$asset = new Asset();
		$this->assetsSender = $asset->registerTwig();
		
        parent::__construct($logger, $c);
		$this->model = new #TPL_PRODUCT#($c->get(EntityManager::class), $c);
		$this->repository = $this->model->repositoryInstance();
		
		//your code...
		return $this;
	}
}
