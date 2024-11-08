<?php

use Dotenv\Dotenv;
use DI\ContainerBuilder;
define('SYS_ROOT', __DIR__);
define('SYS_TIME', time());
define('SYS_TEMPALTE', SYS_ROOT.'/src/Template');
require __DIR__ . '/vendor/autoload.php';
$dotenv = Dotenv::createImmutable(SYS_ROOT);
$dotenv->load();
// Instantiate PHP-DI ContainerBuilder
$containerBuilder = new ContainerBuilder();

if (false) { // Should be set to true in production
	$containerBuilder->enableCompilation(__DIR__ . '/var/cache');
}

// Set up settings
$settings = require __DIR__ . '/app/settings.php';
$settings($containerBuilder);

// Set up dependencies
$dependencies = require __DIR__ . '/app/dependencies.php';
$dependencies($containerBuilder);

// Set up repositories
$repositories = require __DIR__ . '/app/repositories.php';
$repositories($containerBuilder);

// Build PHP-DI Container instance
return $containerBuilder->build();