<?php
declare(strict_types=1);

namespace App\Application\Actions;


use Psr\Http\Message\ResponseInterface as Response;
use Psr\Log\LoggerInterface;
use Psr\Container\ContainerInterface;

use Slim\App;

use App\Domain\DomainException\DomainRecordNotFoundException;

class wControllers extends wActions
{
	private ContainerInterface $c;
	
	public function __construct(LoggerInterface $logger, ContainerInterface $c) {
		parent::__construct($logger, $c);
		$this->c = $c;
	}
	
	protected function controller(): Response
    {
		if (!isset($this->args['Route'])) {
			return $this->action();
		}

		$a = explode('/', rtrim($this->args['Route'],'/'));
		if (!empty($a[0])) {
			$a[0] = ucfirst($a[0]);
			$classPth = __DIR__ . '\\' . $a[0];
			$class = $a[0] . 'Controller';
			$fName = $classPth . '\\' . $class . '.php';
			$_args = array_slice($a,1);
			$this->args = ['Route' => implode('/',$_args)];
			if (method_exists(__CLASS__, $class)) {
				return $this->$class();
			} else if (file_exists($fName)) {
				/*
				require_once $fName;
				return (new (__NAMESPACE__ . '\\' . $a[0] . '\\' . $class)($this->logger, $this->c, $this))->__invoke($this->request, $this->response, $this->args);
				//*/
				/*
				$m = $_SERVER['REQUEST_METHOD'];
				$app = $this->c->get(App::class);
				$res;
				eval(str_replace('#MODEL#', strtolower($a[0]), str_replace('#METHOD#', strtolower($m), str_replace('#DIR##NAME#', __NAMESPACE__ . '\\' . $class, 'use Slim\Interfaces\RouteCollectorProxyInterface as Group;
					$res = $app->group("/#MODEL#", function (Group $group) {
						$group->#METHOD#("", "#DIR##NAME#");
						$group->#METHOD#("/", "#DIR##NAME#");
						$group->#METHOD#("/{Route:.*}", "#DIR##NAME#");
					});
				'))));
				return $res;
				*/
				//*
				$app = $this->c->get(App::class);
				$autoController = require __DIR__ . '/../../../App/autoController.php';
				$autoController($app, $a[0]);
				
				$aObj = $app->getRouteCollector()->getRoutes();
				
//var_dump($app->getRouteCollector()->getBasePath());

				foreach ($aObj as $k => $r) {
					var_dump ($r->getArguments());
					if (!empty($r->getArguments()) && !empty($r->getArguments()['Route'])) {
						return $r->handle($this->request);
					}
//					echo "<br>\n";
				}
//var_dump(1); die;
//*/
			} 
			throw new DomainRecordNotFoundException('BAD Request.');
		}
		return $this->action();
	}
	
    protected function action(): Response
    {	
		$this->response->getBody()->write('WWW Root... Hello world! ');
		return $this->response;
    }
}

