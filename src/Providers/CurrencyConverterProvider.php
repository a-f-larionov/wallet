<?php

namespace App\Providers;

use App\Providers\Interfaces\ProviderInterface;
use App\Services\CurrencyConverter;
use Psr\Container\ContainerInterface;

/**
 * Class CurrencyConverterProvider
 * @package App\Providers
 */
class CurrencyConverterProvider implements ProviderInterface
{
    /**
     * @param ContainerInterface $container
     * @return CurrencyConverter
     */
    public static function create(ContainerInterface $container): CurrencyConverter
    {
        return $container->make(CurrencyConverter::class);
    }
}