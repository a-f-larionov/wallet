<?php

use App\Controllers\IndexController;
use App\Controllers\WalletController;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

return function (RoutingConfigurator $routes) {

    $routes->add('createWallet', 'createWallet/{userId}/{currencyCode}')
        ->controller([WalletController::class, 'create']);

    $routes->add('getBalance', '/getBalance/{walletId}')
        ->controller([WalletController::class, 'getBalance']);

    $routes->add('changeBalance', '/changeBalance/{walletId}/{type}/{sum}/{currencyCode}/{reason}')
        ->controller([WalletController::class, 'changeBalance']);

};