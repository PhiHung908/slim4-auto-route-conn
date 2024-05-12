<?php

declare(strict_types=1);

namespace App\Domain\User;

use App\Domain\User\User;
use App\Domain\User\RepositoryInterface;

use \DI;
use Doctrine\ORM\EntityManager;
use App\Domain\DomainException\DomainRecordNotFoundException;

use Psr\Http\Message\ResponseInterface as Response;

use Slim\App;

class Repository implements RepositoryInterface
{
	private $_db;
	private $_em;
	private $_em_Repository;
	private $_settings;
	protected $twig;
	
    public function __construct($em, $db = null, $appSettings = null)
    {
		$this->_em = $em;// ?? $GLOBALS['container']->get(EntityManager::class);
		$this->_em_Repository = $this->_em->getRepository(User::class);
		$this->_db = $db;
		$this->_settings = $appSettings;
	}
	
	
	public function db($db = null) {
		return $this->_db;
	}
	
	public function em() {
		return $this->_em;
	}
	public function emRepository() {
		return $this->_em_Repository;
	}

    
	/**
	  * {@inheritdoc}
	  */
	public function repositoryInstance(): self
	{
		return $this;
	}
	
	/**
     * {@inheritdoc}
     */
    public function findAll($request = null, $response = null, $args = null): array
    {
		return array_values($this->_em_Repository->findAll(User::class));
    }
	
    /**
     * {@inheritdoc}
     */
    public function findById(int $id): User
    {
		$r = $this->_em_Repository->find($id);
		if (empty($r)) {
            throw new DomainRecordNotFoundException();
        }
        return $r;
    }
}
