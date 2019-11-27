<?php

namespace App\Providers;

use App\Providers\Interfaces\ProviderInterface;
use App\Services\CurrencyConverter;
use Psr\Container\ContainerInterface;
use Symfony\Component\Routing\Router;

/**
 * Class CurrencyConverterProvider
 * @package App\Providers
 */
class CurrencyConverterProvider implements ProviderInterface
{
    /**
     * @param ContainerInterface $container
     * @return Router
     */
    public static function create(ContainerInterface $container): CurrencyConverter
    {
        return $container->make(CurrencyConverter::class);
    }
}