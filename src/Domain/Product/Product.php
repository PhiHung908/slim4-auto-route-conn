<?php
// src/Product/Product.php

namespace App\Domain\Product;

use Doctrine\ORM\EntityManager;
use App\Domain\Product\Repository;

use DateTimeImmutable;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;

use JsonSerializable;

#[Entity, Table(name: 'Product')]
class Product extends Repository implements JsonSerializable
{	
	#[Id, Column(type: 'integer'), GeneratedValue(strategy: 'AUTO')]
	private int|null $id = null;
    
	#[Column(type: 'string')]
	private string $name;
	
	
	public function __construct($em = null, $c = null)
    {
		parent::__construct($em, $c);
		//your code...
	}

    public function getId(): ?int
    {
        return $this->id;
    }
	
	public function getName(): ?int
    {
        return $this->name;
    }
	
	
	#[\ReturnTypeWillChange]
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
        ];
    }
	
	/**
	  * {@overlap}
	  */
	public function repositoryInstance(): Repository {
		return parent::repositoryInstance();
	}
}
