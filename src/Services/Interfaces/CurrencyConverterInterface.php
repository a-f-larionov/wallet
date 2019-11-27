<?php

namespace App\Services\Interfaces;

use App\Models\Currency;
use App\Models\Money;

/**
 * Class CurrencyConverterInterface
 * @package App\Services\Interfaces
 */
interface CurrencyConverterInterface
{
    /**
     * Возвращает курс обмена для пары валют.
     * @param Currency $from
     * @param Currency $to
     * @return float
     */
    public function getRate(Currency $from, Currency $to): float;

    /**
     * Конвертирует деньги в запрашиваемую валюту.
     * @param Money $money
     * @param Currency $currency
     */
    public function convertTo(Money $money, Currency $currency): void;
}