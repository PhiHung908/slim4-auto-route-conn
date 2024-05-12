<?php

declare(strict_types=1);

namespace App\Domain\User;

//use Doctrine\ORM\EntityRepository;

use DateTimeImmutable;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;


use JsonSerializable;

#[Entity, Table(name: 'user')]
class User /* extends EntityRepository */ implements JsonSerializable
{
	
	#[Id, Column(type: 'integer'), GeneratedValue(strategy: 'AUTO')]
	private ?int $id;

	#[Column(type: 'string')]
    private string $username;

	#[Column(type: 'string')]
    private string $firstname;

	#[Column(type: 'string')]
    private string $lastname;
	

    public function __construct(?int $id = null, string $username = '', string $firstName = '', string $lastName = '')
    {
		//*
		$this->id = $id;
		$this->username = strtolower($username);
        $this->firstname = ucfirst($firstName);
        $this->lastname = ucfirst($lastName);
		//*/
		return $this;
    }
	
	
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getFirstName(): string
    {
        return $this->firstname;
    }

    public function getLastName(): string
    {
        return $this->lastname;
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
}
