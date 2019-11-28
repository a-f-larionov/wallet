<?php

namespace App\Repositories;

use App\Api\CBRFClient;
use App\Exceptions\UserRequestErrorException;
use App\Models\Currency;
use App\Repositories\Interfaces\CurrencyPairRateRepositoryInterface;
use GuzzleHttp\Client;

/**
 * Class WalletRepository
 * @package App\Repositories
 */
class CurrencyPairRateRepository implements CurrencyPairRateRepositoryInterface
{
    /**
     * @var Client
     */
    private Client $client;

    /**
     * @var CBRFClient
     */
    private CBRFClient $cbrfClient;

    /**
     * CurrencyPairRateRepository constructor.
     * @param CBRFClient $cbrfClient
     * @param Client $client
     */
    public function __construct(CBRFClient $cbrfClient, Client $client)
    {
        $this->client = $client;
        $this->cbrfClient = $cbrfClient;
    }

    /**
     * Возврщает курс обмена для пар.
     * @param Currency $from
     * @param Currency $to
     * @return float
     * //@throws UserRequestErrorException
     * @todo клиент к СБРФ, Сущность Пар и т.д.
     */
    public function getFor(Currency $from, Currency $to): float
    {
        $rates = $this->cbrfClient->getRates();

        if ($from->getCode() == 'USD' &&
            $to->getCode() == 'RUB') {
            return $rates['USDToRUB'];
        }
        if ($from->getCode() == 'RUB' &&
            $to->getCode() == 'USD') {
            return $rates['RUBToUSD'];
        }

        throw new UserRequestErrorException("Unknown Currency Pair.");
    }
}