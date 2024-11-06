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
                    'dsn' => 'mysql:host='.$_ENV['DB_HOST'].';dbname='.$_ENV['DB_NAME'].';charset=utf8;port=3306',
                    'driver' => 'pdo_mysql',
                    'user' => $_ENV['DB_USER'],
                    'password' => $_ENV['DB_PASS'],
                    'charset' => 'utf8mb4'
                ],
                'cache' => [
                    'driver' => 'redis',
                    'link' => [
                        'redis' => [
                            'dsn' => 'redis://localhost:6379/'.$_ENV['REDIS_DATABASE']
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
						'username' => $_ENV['PAY_PAYPAL_USERNAME'],
						'password' => $_ENV['PAY_PAYPAL_PASSWORD'],
						'signature' => $_ENV['PAY_PAYPAL_SIGNATURE'],
						'currency' => $_ENV['PAY_PAYPAL_CURRENCY']
					],
					'stripe' => [
						'apikey' => $_ENV['PAY_STRIPE_APIKEY']
					]
				]
            ]);
        }
    ]);
};
