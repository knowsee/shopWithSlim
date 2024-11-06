<?php

declare(strict_types=1);

use \Exception as Exception;
use App\Application\Settings\SettingsInterface;
use DI\ContainerBuilder;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\UidProcessor;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;

/**
 * PHP-VIEW
 */

use Slim\Views\PhpRenderer;

/**
 * DATABASE-ORM
 */
use App\Infrastructure\Driver\Pdo as PdoDriver;
use Slim\PDO\Database;

/**
 * CACHE
 */

use App\Infrastructure\Driver\Cache as CacheDriver;
use Symfony\Component\Cache\Adapter\RedisAdapter;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\Cache\Marshaller\DefaultMarshaller;
use Symfony\Component\Cache\Marshaller\DeflateMarshaller;

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
        'view' => function (ContainerInterface $container) {
            return new PhpRenderer(SYS_TEMPALTE);
        },
        PdoDriver::class => function (ContainerInterface $container): Database {
            $settings = $container->get(SettingsInterface::class)->get();
            $pdo = new Database(
                $settings['database']['dsn'],
                $settings['database']['user'],
                $settings['database']['password']
            );
            return $pdo;
        },
        CacheDriver::class => function (ContainerInterface $container) {
            $settings = $container->get(SettingsInterface::class)->get();
            switch ($settings['cache']['driver']) {
                case 'redis':
                    if (empty($settings['cache']['link']['redis']['dsn'])) {
                        throw new Exception('redis dsn not found');
                    }
                    $client = RedisAdapter::createConnection(
                        $settings['cache']['link']['redis']['dsn'],
                        [
                            'lazy' => false,
                            'persistent' => 0,
                            'persistent_id' => null,
                            'tcp_keepalive' => 0,
                            'timeout' => 30,
                            'read_timeout' => 0,
                            'retry_interval' => 0,
                        ]
                    );
                    $marshaller = new DeflateMarshaller(new DefaultMarshaller());
                    $cache = new RedisAdapter(
                        $client,
                        $settings['cache']['namespace'],
                        $settings['cache']['lifetime'],
                        $marshaller
                    );
                    break;
                default:
                    $cache = new FilesystemAdapter(
                        $settings['cache']['namespace'],
                        $settings['cache']['lifetime'],
                        $settings['cache']['dir']
                    );
            }
            return $cache;
        }
    ]);

};
