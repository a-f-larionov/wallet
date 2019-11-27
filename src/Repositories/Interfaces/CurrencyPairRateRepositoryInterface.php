<?php

namespace App\Repositories\Interfaces;

use App\Models\Currency;

/**
 * Interface WalletRepositoryInterface
 * @package App\Repositories\Interfaces
 */
interface CurrencyPairRateRepositoryInterface
{
    /**
     * @param Currency $from
     * @param Currency $to
     * @return float
     */
    public function getFor(Currency $from, Currency $to): float;
}