<?php

// bootstrap.php

use Doctrine\ORM\EntityManager;
use DI\ContainerBuilder;
//use DI\Container;

use App\Application\Settings\SettingsInterface;

require_once __DIR__ . '/../vendor/autoload.php';

// Instantiate PHP-DI ContainerBuilder
$containerBuilder = new ContainerBuilder();

if (false) { // Should be set to true in production
	$containerBuilder->enableCompilation(__DIR__ . '/../var/cache');
}

// Set up settings
$settings = require __DIR__ . '/../app/settings.php';
$settings($containerBuilder);

// Set up dependencies
$dependencies = require __DIR__ . '/../app/dependencies.php';
$dependencies($containerBuilder);

// Set up repositories
$repositories = require __DIR__ . '/../app/repositories.php';
$repositories($containerBuilder);

// Set up PDO and doctrine-entity
$diConn = require __DIR__ . '/../app/di-conn.php';
$diConn($containerBuilder);


// Build PHP-DI Container instance
/* * @var Container $container */
$container = $containerBuilder->build();

/** @var EntityManager $entityManager */
//$entityManager = $container->get(EntityManager::class);

