<?php

namespace App\Providers;

use App\Providers\Interfaces\ProviderInterface;
use App\Views\WalletViews;
use Psr\Container\ContainerInterface;

/**
 * Class ViewsProvider
 * @package App\Providers
 */
class ViewsProvider implements ProviderInterface
{
    /**
     * @param ContainerInterface $container
     * @return mixed
     */
    public static function create(ContainerInterface $container)
    {
        return new WalletViews();
    }
}