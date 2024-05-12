<?php

declare(strict_types=1);

use App\Domain\User\DbUserRepository;
//use App\Infrastructure\Persistence\User\InMemoryUserRepository;

use Doctrine\ORM\EntityManager;
use App\Application\Settings\SettingsInterface;


use App\Domain\User\UserRepository;
use DI\ContainerBuilder;


return function (ContainerBuilder $containerBuilder) {
    // Here we map our UserRepository interface to its in memory implementation
    $containerBuilder->addDefinitions([
        //UserRepository::class => \DI\autowire(InMemoryUserRepository::class),
		//*
		UserRepository::class => function($DIContainer, $FactoryDefinition){
			//return new InMemoryUserRepository([]);
			
			$settings = $DIContainer->get(SettingsInterface::class)->get();
			$dbType = !key_exists('dbdefault',$settings) || $settings['dbdefault'] === 'doctrine' ? 'doctrine' : 'pdo';
			return new DbUserRepository($dbType === 'doctrine' ? $DIContainer->get(EntityManager::class) : null, $dbType === 'pdo' ? $DIContainer->get(\PDO::class) : null, $settings);
		},
		//*/
		//UserRepository::class => \DI\create(DbUserRepository::class)->constructor(\DI\get(EntityManager::class)),
    ]);
};
