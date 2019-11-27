<?php

namespace App\Providers;

use App\Providers\Interfaces\ProviderInterface;
use App\Repositories\TransactionLogsRepository;
use Psr\Container\ContainerInterface;

/**
 * Class TransactionLogsRepositoryProvider
 * @package App\Providers
 */
class TransactionLogsRepositoryProvider implements ProviderInterface
{
    /**
     * @param ContainerInterface $container
     * @return mixed
     */
    public static function create(ContainerInterface $container)
    {
        return $container->make(TransactionLogsRepository::class);
    }
}