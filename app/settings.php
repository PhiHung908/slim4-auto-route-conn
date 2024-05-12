<?php

declare(strict_types=1);

use App\Application\Settings\Settings;
use App\Application\Settings\SettingsInterface;
use DI\ContainerBuilder;
use Monolog\Logger;


define('APP_ROOT', __DIR__ . '/..');

return function (ContainerBuilder $containerBuilder) {
    // Global Settings Object
    $containerBuilder->addDefinitions([
        SettingsInterface::class => function () {
			$db_default = [
						'driver' => 'mysql',
						'host' => 'localhost',
						'port' => 3306,
						'dbname' => 'slim_db', //'yii2advanced', //'slim_db',
						'user' => 'root',
						'password' => 'root',
						'charset' => 'utf8mb4',
						'collation' => 'utf8mb4_unicode_ci',
						'flags' => [
							// Turn off persistent connections
							\PDO::ATTR_PERSISTENT => false,
							// Enable exceptions
							\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
							// Emulate prepared statements
							\PDO::ATTR_EMULATE_PREPARES => true,
							// Set default fetch mode to array
							\PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC
						]
					];
					
			$db_default_doctrine = $db_default;
			$db_default_doctrine['driver'] = 'pdo_mysql';
			
            return new Settings([
                'displayErrorDetails' => true, // Should be set to false in production
                'logError'            => false,
                'logErrorDetails'     => false,
                'logger' => [
                    'name' => 'slim-app',
                    'path' => isset($_ENV['docker']) ? 'php://stdout' : __DIR__ . '/../logs/app.log',
                    'level' => Logger::DEBUG,
                ],
				'alias' => [
					'Hwg' => 'vendor\\slim4-mod\\hwg',
					'Hwg/Helper' => 'vendor\\slim4-mod\\helper',
				],
				'components' => [
					'Hwg' => [
						'class' => 'Hwg\\app',
						'admin' => 'Hwg\\app\\admin',
					],
				],
				'dbdefault' => 'doctrine',
				'db' => $db_default,
				'doctrine' => [
					// Enables or disables Doctrine metadata caching
					// for either performance or convenience during development.
					'dev_mode' => true,

					// Path where Doctrine will cache the processed metadata
					// when 'dev_mode' is false.
					'cache_dir' => APP_ROOT . '/var/doctrine',

					// List of paths where Doctrine will search for metadata.
					// Metadata can be either YML/XML files or PHP classes annotated
					// with comments or PHP8 attributes.
					'metadata_dirs' => [APP_ROOT . '/src/Domain'],

					// The parameters Doctrine needs to connect to your database.
					// These parameters depend on the driver (for instance the 'pdo_sqlite' driver
					// needs a 'path' parameter and doesn't use most of the ones shown in this example).
					// Refer to the Doctrine documentation to see the full list
					// of valid parameters: https://www.doctrine-project.org/projects/doctrine-dbal/en/current/reference/configuration.html
					'connection' => $db_default_doctrine
				],
            ]);
        }
    ]);
};
