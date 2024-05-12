<?php

declare(strict_types=1);

namespace App\Application\Actions\Product\AutoGen;

use App\Domain\Product\Product;
use App\Domain\Product\Repository;

use App\Base\ActionTwig;

use Psr\Log\LoggerInterface;
use Psr\Container\ContainerInterface;
use Doctrine\ORM\EntityManager;

abstract class ProductAction extends ActionTwig
{
    protected Repository $repository;
	protected $model;
	
	public function __construct(LoggerInterface $logger, ContainerInterface $c)
    {
		
		$asset = new Asset();
		$this->assetsSender = $asset->registerTwig();
		
        parent::__construct($logger, $c);
		$this->model = new Product($c->get(EntityManager::class), $c);
		$this->repository = $this->model->repositoryInstance();
		
		//your code...
		return $this;
	}
}
