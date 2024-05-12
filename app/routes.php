<?php

declare(strict_types=1);

//use App\Application\Actions\wControllers;


use Doctrine\ORM\EntityManager;
use Psr\Log\LoggerInterface;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;


return function (App $app) {
	
	/*
	//#[Route("{/routes:.*}")]
	$app->options('/{routes:.*}', function (Request $request, Response $response) {
		// CORS Pre-Flight OPTIONS Request Handler
		return $response;
	});
	*/
	
	/*
	//#[Route("/")]
	$app->group('/', function (Group $group) {
		$group->get('{Route:.*}', wControllers::class);
	});
	//*/
	//*
	
	//*
	$autoController = require  '..\src\Base\AutoController.php';
	$aUri = explode('/',$_SERVER['REQUEST_URI'] . '/');
	$autoController($app, ucfirst($aUri[1]), ucfirst($aUri[2]));
	//*/
	
	//#[Route("/")]
	$app->get('/hello/{name}', function (Request $request, Response $response, $args) {
		$response->getBody()->write('Hello world! ' . $args['name'] );
		return $response;
	});
	
	/*
	$app->group("/product", function (Group $group) {
		$group->get("", "App\Application\Actions\Product\AutoGen\ProductController");
		$group->get("/", "App\Application\Actions\Product\AutoGen\ProductController");
		$group->get("/{Route:[^(row/)].*}", "App\Application\Actions\Product\AutoGen\ProductController");
		$group->get("/row", "App\Application\Actions\Product\RowAction");
		$group->get("/row/", "App\Application\Actions\Product\RowAction");
		$group->get("/row/{id}", "App\Application\Actions\Product\RowAction");
	});
	//*/
};
