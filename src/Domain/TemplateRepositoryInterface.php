<?php

declare(strict_types=1);

namespace App\Domain\#TPL_PRODUCT#;

use App\Domain\Interfaces\GlobalRepositoryInterface;
use Psr\Http\Message\ResponseInterface as Response;

interface RepositoryInterface extends GlobalRepositoryInterface
{	
    /**
     * @param int $id
     * @return #TPL_PRODUCT#
     * @throws RecodNotFoundException
     */
    public function findById(int $id): #TPL_PRODUCT#;
}
