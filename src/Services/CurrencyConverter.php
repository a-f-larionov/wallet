<?php

namespace App\Services;

use App\Models\Currency;
use App\Models\Money;
use App\Repositories\Interfaces\CurrencyPairRateRepositoryInterface;
use App\Services\Interfaces\CurrencyConverterInterface;

/**
 * Конвертер валют
 * Class CurrencyConverter
 * @package App\Services
 */
class CurrencyConverter implements CurrencyConverterInterface
{

    private CurrencyPairRateRepositoryInterface $currencyPairRateRepository;

    public function __construct(CurrencyPairRateRepositoryInterface $currencyPairRateRepository)
    {
        $this->currencyPairRateRepository = $currencyPairRateRepository;
    }

    /**
     * Возвращает курс валют
     * @param Currency $currencyFrom
     * @param Currency $currencyTo
     * @return float
     */
    public function getRate(Currency $currencyFrom, Currency $currencyTo): float
    {
        $rate = $this->currencyPairRateRepository->getFor($currencyFrom, $currencyTo);

        return $rate;
    }

    /**
     * Конвертирует деньги в указанную валюту.
     * @param Money $money
     * @param Currency $currency
     */
    public function convertTo(Money $money, Currency $currency): void
    {
        if ($money->getCurrency()->getNum() == $currency->getNum()) {
            return;
        }

        $rate = $this->getRate($money->getCurrency(), $currency);

        $money->setRawSum($money->getRawSum() * $rate);
        $money->setCurrency($currency);
    }
}