<?php

namespace App\Repositories\Interfaces;

use App\Models\Wallet;

/**
 * Interface WalletRepositoryInterface
 * @package App\Repositories\Interfaces
 */
interface WalletRepositoryInterface
{
    /**
     * @param int $userId
     * @return bool
     */
    public function existsByUserId(int $userId): bool;

    /**
     * @param int $id
     * @return Wallet
     */
    public function findById(int $id): Wallet;

    /**
     * @param int $userId
     * @param string $currencyCode
     * @return Wallet
     */
    public function create(int $userId, string $currencyCode): Wallet;
}