<?php

declare(strict_types=1);

namespace App\Domain\User;

use App\Domain\User\User;
use App\Domain\User\UserNotFoundException;
use App\Domain\User\UserRepository;

class DbUserRepository implements UserRepository
{
	private $_db;
	private $_em;
	private $_rp;
	private $_settings;
	
    public function __construct(/*EntityManager*/ $em = null, /*\PDO*/ $db = null, $appSettings = null)
    {
		$this->_em = $em;
		$this->_rp = $this->_em->getRepository(User::class);
		$this->_db = $db;
		$this->_settings = $appSettings;
	}
	
	
	public function db($db = null) {
		return $this->_db;
	}
	
	public function em() {
		return $this->_em;
	}
	public function rp() {
		return $this->_rp;
	}

    /**
     * {@inheritdoc}
     */
    public function findAll($request = null, $response = null, $args = null): array
    {
		/* PDO sql
		$sth = $this->_db->prepare("SELECT * FROM user");
		$sth->execute();
		$data = $sth->fetchAll(\PDO::FETCH_ASSOC);
		return array_values($data);
		//*/
		return array_values($this->_rp->findAll(User::class));
    }

    /**
     * {@inheritdoc}
     */
    public function findById(int $id): User
    {
		$u = $this->_rp->find($id);
		if (empty($u)) {
            throw new UserNotFoundException();
        }
        return $u;
    }
}
