<?php

declare(strict_types=1);

namespace App\Domain\Interfaces;

use Psr\Http\Message\ResponseInterface as Response;

interface GlobalRepositoryInterface
{	
    
	/**
	  * @return self
	  */
	public function repositoryInstance(): self;
	
	
	/**
     * @return Product[]
     */
    public function findAll(): array;
}
