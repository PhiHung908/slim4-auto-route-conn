<?php
declare(strict_types=1);

namespace App\Application\Actions\User\AutoGen;

use App\Application\Actions\mController;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Log\LoggerInterface;
use Psr\Container\ContainerInterface;

use Slim\App;
use App\Domain\DomainException\DomainRecordNotFoundException;

class UserController extends UserAction
{
	private $isInternal = false;
	

	public function __construct(LoggerInterface $logger, protected ?ContainerInterface $c) {
		parent::__construct($logger, $c);
	}
	

	public function controller(): Response
    {
		if (!isset($this->args['Route'])) {
			$this->isInternal = true;
			return $this->action();
		}

		$a = explode('/', rtrim($this->args['Route'],'/'));
		if (!empty($a[0])) {
			$_args = array_slice($a,1);
			$this->args = $_args;
			$classPth = __DIR__ ;
			$class = ucfirst($a[0]) . 'Action';
			$fName = $classPth . '\\..\\' . $class . '.php';
			if (method_exists(__CLASS__, $class)) {
				return $this->$class();
			} else if (file_exists($fName)) {
				require_once $fName;
				return (new (dirname(__NAMESPACE__ ) . '\\' . $class)($this->logger, $this->c))->__invoke($this->request, $this->response, $_args);
			} 
			throw new DomainRecordNotFoundException('Request is invalid.');
		}
		return $this->action();
	}
	
	protected function Action(): Response
    {
		if (!$this->isInternal) {
			$fName = __DIR__ . '\\..\\' . 'IndexAction.php';
			if (file_exists($fName)) {
				$this->args = array_slice($this->args, 1);
				require_once $fName;
				return (new (dirname(__NAMESPACE__) . '\\IndexAction')($this->logger, $this->c))->__invoke($this->request, $this->response, $this->args);
			} 
		}
		$this->response->getBody()->write('Body by Default User ControllerAction');
		return $this->response;
	}
	
	protected function TestAction(): Response
	{
		$this->response->getBody()->write('Body by Direct TestAction in User ControllerAction');
		return $this->response;
	}
}
