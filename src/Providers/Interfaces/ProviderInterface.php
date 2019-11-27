<?php

namespace App\Providers\Interfaces;

use Psr\Container\ContainerInterface;

/**
 * Interface ProviderInterface
 * @package App\Providers\Interfaces
 */
interface ProviderInterface
{
    /**
     * @param ContainerInterface $container
     * @return mixed
     */
    public static function create(ContainerInterface $container);
}