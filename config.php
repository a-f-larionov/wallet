<?php

/**
 * Конфигурационный файл.
 */

use App\Providers\CurrencyConverterProvider;
use App\Providers\CurrencyPairRateRepositoryProvider;
use App\Providers\EntityManagerProvider;
use App\Providers\RouterProvider;
use App\Providers\TransactionLogsRepositoryProvider;
use App\Providers\ViewsProvider;
use App\Providers\WalletRepositoryProvider;
use App\Repositories\CurrencyPairRateRepository;
use App\Repositories\Interfaces\CurrencyPairRateRepositoryInterface;
use App\Repositories\Interfaces\TransactionLogsRepositoryInterface;
use App\Repositories\Interfaces\WalletRepositoryInterface;
use App\Services\CurrencyConverter;
use App\Services\Interfaces\CurrencyConverterInterface;
use App\Views\WalletViews;
use Doctrine\ORM\EntityManagerInterface;

use Symfony\Component\Routing\RouterInterface;

return [

    'entityManager' => [
        'driver' => 'pdo_mysql',
        'host' => getenv('DB_HOST', 'localhost'),
        'user' => getenv('DB_USER'),
        'password' => getenv('DB_PASSWORD'),
        'dbname' => getenv('DB_NAME'),
        'echoSQLLog' => false//true//getenv('ECHO_SQL_LOG', true),
    ],

    'providers' => [
        RouterInterface::class => RouterProvider::class,
        WalletViews::class => ViewsProvider::class,
        EntityManagerInterface::class => EntityManagerProvider::class,
        WalletRepositoryInterface::class => WalletRepositoryProvider::class,
        CurrencyPairRateRepositoryInterface::class => CurrencyPairRateRepositoryProvider::class,
        TransactionLogsRepositoryInterface::class => TransactionLogsRepositoryProvider::class,
        CurrencyConverterInterface::class => CurrencyConverterProvider::class
    ],
];