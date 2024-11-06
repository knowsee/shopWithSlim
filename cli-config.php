<?php

// cli-config.php

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Console\ConsoleRunner;
use Slim\Container;
use Slim\Factory\AppFactory;
/** @var Container $container */
$container = require_once __DIR__ . '/bootstrap.php';
AppFactory::setContainer($container);
$app = AppFactory::create();
return ConsoleRunner::createHelperSet($app->getContainer()->get(EntityManager::class));