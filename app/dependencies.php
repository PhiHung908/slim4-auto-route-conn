<?php

declare(strict_types=1);


use Slim\Views\Twig;
//use Glazilla\TwigAsset\TwigAssetManagement;
use App\Base\ExtendsTwigAssetMngr;
use Slim\Views\TwigMiddleware;
use Slim\App;


use App\Domain\User\AllUserRepository;
use Doctrine\ORM\EntityManager;


use App\Application\Settings\SettingsInterface;
use DI\ContainerBuilder;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\UidProcessor;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;

return function (ContainerBuilder $containerBuilder) {
				
	$containerBuilder->addDefinitions([
        LoggerInterface::class => function (ContainerInterface $c) {
            $settings = $c->get(SettingsInterface::class);

            $loggerSettings = $settings->get('logger');
            $logger = new Logger($loggerSettings['name']);

            $processor = new UidProcessor();
            $logger->pushProcessor($processor);

            $handler = new StreamHandler($loggerSettings['path'], $loggerSettings['level']);
            $logger->pushHandler($handler);

            return $logger;
        },
		'view' => function($c) {
			$view = Twig::create($c->get('viewPath'), ['cache' => $c->get('twigCache')]);
			
			$assetManager = new ExtendsTwigAssetMngr([
				'verion' => '1'
			]);
			
			$assetSender = $c->get('assetSender');

			foreach ($assetSender as $dir => $aVal) {
				$assetManager->addPath('assetdir', '/assets/' . $dir);
				foreach($aVal as $k => $file) {
					if (strpos(',js,css,img,', ','.$k.',') !== false) {
						$assetManager->addPath($k, '/assets/' . $dir . '/' . $k);
						$aa = [];
						foreach($file as $z => $fname) {
							$aa[] = '/assets/' . $dir . '/' . $k . '/' . $fname;
						}
						$assetManager->addArrayAsset($dir, [$k => $aa]);
					}
				}
			}
			
			$view->addExtension($assetManager->getAssetExtension());
			return $view;
		},
		'addTwigMiddleware' => function($c) {
			$c->get(App::class)->add(TwigMiddleware::createFromContainer($c->get(App::class)));
		}
	]);
};
