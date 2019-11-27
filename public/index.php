<?php

/**
 * Entry Point Фреймоврка.
 */

use App\App;
use Psr\Container\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Автозлоадер from composer.
 * @see https://getcomposer.org/
 * @see https://www.php-fig.org/psr/psr-4/
 */
require_once __DIR__ . '/../vendor/autoload.php';

/** @var ContainerInterface $container */
$container = require_once __DIR__ . '/../bootstrap.php';

$app = App::create($container);

$request = Request::createFromGlobals();

$response = $app->handle($request);

$response->send();