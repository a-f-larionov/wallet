<?php

namespace App\Repositories;

use App\Api\CBRFClient;
use App\Exceptions\UserRequestErrorException;
use App\Models\Currency;
use App\Repositories\Interfaces\CurrencyPairRateRepositoryInterface;

/**
 * Class WalletRepository
 * @package App\Repositories
 */
class CurrencyPairRateRepository implements CurrencyPairRateRepositoryInterface
{
    /**
     * @var CBRFClient
     */
    private CBRFClient $cbrfClient;

    /**
     * CurrencyPairRateRepository constructor.
     * @param CBRFClient $cbrfClient
     */
    public function __construct(CBRFClient $cbrfClient)
    {
        $this->cbrfClient = $cbrfClient;
    }

    /**
     * Возврщает курс обмена для пар.
     * @param Currency $from
     * @param Currency $to
     * @return float
     * //@throws UserRequestErrorException
     * @todo сущность пар, кэширование\или БД.
     */
    public function getFor(Currency $from, Currency $to): float
    {
        $rates = $this->cbrfClient->getRates();

        if (isset($rates[$from->getCode() . 'To' . $to->getCode()])) {
            return $rates[$from->getCode() . 'To' . $to->getCode()];
        }

        throw new UserRequestErrorException("Unknown Currency Pair.");
    }
}