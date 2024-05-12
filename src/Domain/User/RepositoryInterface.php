<?php

declare(strict_types=1);

namespace App\Domain\User;

use App\Domain\Interfaces\GlobalRepositoryInterface;
use Psr\Http\Message\ResponseInterface as Response;

interface RepositoryInterface extends GlobalRepositoryInterface
{	
    /**
     * @param int $id
     * @return User
     * @throws RecodNotFoundException
     */
    public function findById(int $id): User;
}
