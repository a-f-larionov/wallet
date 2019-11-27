<?php

namespace App\Repositories\Interfaces;

use App\Models\Money;
use App\Models\Wallet;

interface TransactionLogsRepositoryInterface
{
    /**
     * @param Wallet $wallet
     * @param Money $money
     * @param string $type
     * @param string $reason
     * @return mixed
     */
    public function add(Wallet $wallet, Money $money, string $type, string $reason);
}