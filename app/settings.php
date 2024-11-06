<?php

declare(strict_types=1);

use App\Application\Settings\Settings;
use App\Application\Settings\SettingsInterface;
use DI\ContainerBuilder;
use Monolog\Logger;

return function (ContainerBuilder $containerBuilder) {

    // Global Settings Object
    $containerBuilder->addDefinitions([
        SettingsInterface::class => function () {
            return new Settings([
                'displayErrorDetails' => true, // Should be set to false in production
                'logError'            => true,
                'logErrorDetails'     => false,
                'logger' => [
                    'name' => 'slim-app',
                    'path' => isset($_ENV['docker']) ? 'php://stdout' : __DIR__ . '/../logs/app.log',
                    'level' => Logger::DEBUG,
                ],
                'database' => [
                    'dsn' => 'mysql:host=localhost;dbname=shop_new;charset=utf8;port=3306',
                    'driver' => 'pdo_mysql',
                    'user' => 'root',
                    'password' => 'chengyi94',
                    'charset' => 'utf8mb4'
                ],
                'cache' => [
                    'driver' => 'redis',
                    'link' => [
                        'redis' => [
                            'dsn' => 'redis://localhost:6379/3'
                        ]
                    ],
                    'dir' => SYS_ROOT.'/var/cache/',
                    'namespace' => 'd2c3',
                    'lifetime' => 3600
                ],
                'cookies' => [
                    'domain' => $_ENV['COOKIES_DOMIAN'],
                    'lifetime' => 86400,
                    'prefix' => $_ENV['COOKIES_PREX'],
                    'path' => $_ENV['COOKIES_PATH'],
                    'safe' => true,
                ],
				'pay' => [
					'paypal' => [
						'username' => 'PALPAL-DEV',
						'password' => 'PASSWORD',
						'signature' => 'SIGNATURE',
						'currency' => 'HKD'
					],
					'stripe' => [
						'apikey' => 'stripe APIKEY'
					]
				]
            ]);
        }
    ]);
};
