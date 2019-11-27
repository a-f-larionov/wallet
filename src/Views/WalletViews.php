<?php

namespace App\Views;

use App\Models\Wallet;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Этот класс представляет слой представления в MVC.
 * Class WalletViews
 * @package App\WalletViews
 */
class WalletViews
{
    /**
     * @param Wallet $wallet
     * @return JsonResponse
     */
    public function getWalletResponse(Wallet $wallet): JsonResponse
    {
        return new JsonResponse([
            'id' => $wallet->getId(),
            'userId' => $wallet->getUserId(),
            'currency' => $wallet->getMoney()->getCurrency()->getCode(),
            'balance' => $wallet->getMoney()->getAmount(),
        ]);
    }

    /**
     * @param Wallet $wallet
     * @return JsonResponse
     */
    public function getBalanceResponse(Wallet $wallet): JsonResponse
    {
        return new JsonResponse([
            'currency' => $wallet->getMoney()->getCurrency()->getCode(),
            'balance' => $wallet->getMoney()->getAmount(),
        ]);
    }
}