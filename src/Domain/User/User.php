<?php
// src/User/User.php

namespace App\Domain\User;

use Doctrine\ORM\EntityManager;
use App\Domain\User\Repository;

use DateTimeImmutable;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;

use JsonSerializable;

#[Entity, Table(name: 'User')]
class User extends Repository implements JsonSerializable
{	
	#[Id, Column(type: 'integer'), GeneratedValue(strategy: 'AUTO')]
	private ?int $id;

	#[Column(type: 'string')]
    private string $username;

	#[Column(type: 'string')]
    private string $firstname;

	#[Column(type: 'string')]
    private string $lastname;
	
	
	public function __construct($em = null, $c = null)
    {
		parent::__construct($em, $c);
		//your code...
	}

    public function getId(): ?int
    {
        return $this->id;
    }
	
	
	#[\ReturnTypeWillChange]
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'username' => $this->username,
            'firstName' => $this->firstname,
            'lastName' => $this->lastname,
        ];
    }
	
	/**
	  * {@overlap}
	  */
	public function repositoryInstance(): Repository {
		return parent::repositoryInstance();
	}
}
