<?php

declare(strict_types=1);

namespace App\Domain\Product;

use App\Domain\Interfaces\GlobalRepositoryInterface;
use Psr\Http\Message\ResponseInterface as Response;

interface RepositoryInterface extends GlobalRepositoryInterface
{	
    /**
     * @param int $id
     * @return Product
     * @throws RecodNotFoundException
     */
    public function findById(int $id): Product;
}
