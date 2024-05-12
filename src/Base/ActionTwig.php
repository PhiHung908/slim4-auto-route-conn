<?php

declare(strict_types=1);

namespace App\Base;

use App\Application\Actions\Action;

use App\Domain\DomainException\DomainRecordNotFoundException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Log\LoggerInterface;
use Psr\Container\ContainerInterface;
use Slim\Exception\HttpBadRequestException;
use Slim\Exception\HttpNotFoundException;

abstract class ActionTwig extends Action
{
	private $modelName;
	protected $settings;
	
	
	protected array $assetsSender = [];
	
    
	public function __construct(?LoggerInterface $logger = null, protected ?ContainerInterface $c = null)
    {
		parent::__construct($logger);
	
		$this->modelName = array_slice(explode('\\',get_called_class()),-2,1)[0];
		if ($this->modelName === 'AutoGen') $this->modelName = array_slice(explode('\\',get_called_class()),-3,1)[0];
		$c->set('viewPath', $this->viewPath());
		$c->set('assetSender', $this->assetsSender);
		$c->set('twigCache', $this->baseDir('var\\cache\\twig'));
		$c->get('addTwigMiddleware');
	}

	/**
	  * @return string
	  */
	protected function baseDir($append = null): string
	{
		return __DIR__ . '\\..\\..' . (!empty($append) ? '\\' . $append : '');
	}

	/**
	  * @return string
	  */
	protected function viewPath($modelName = null): string
	{
		$_modelName = $modelName;
		if (empty($_modelName)) $_modelName = $this->modelName;
		return $this->baseDir('src\\Views' . (!empty($_modelName) ? '\\' . $_modelName : '') ) ;
	}
	
	/**
	  * @return Response
	  */
	protected function render($tplViewFile, $args = []): Response {
		$_args = ['data' => array_merge($args, ['params' => $this->args], ['model' => ['modelName' => $this->modelName] ])];
		return $this->c->get('view')->render($this->response, $tplViewFile, $_args);
	}
	
	/**
	  * @return Response
	  */
	protected function fetchFromString($strTpl, $args = []): Response {
		$_args = ['data' => array_merge($args, ['params' => $this->args], ['model' => ['modelName' => $this->modelName] ])];
		$this->response->getBody()->write( $this->c->get('view')->fetchFromString($this->response, $strTpl, $_args));
		return $this->response; 
	}
}
