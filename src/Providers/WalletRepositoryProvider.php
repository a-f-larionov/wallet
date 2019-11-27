<?php

namespace App\Providers;

use App\Providers\Interfaces\ProviderInterface;
use App\Repositories\WalletRepository;
use Psr\Container\ContainerInterface;

/**
 * Class WalletRepositoryProvider
 * @package App\Providers
 */
class WalletRepositoryProvider implements ProviderInterface
{
    /**
     * @param ContainerInterface $container
     * @return mixed
     */
    public static function create(ContainerInterface $container)
    {
        return $container->make(WalletRepository::class);
    }
}