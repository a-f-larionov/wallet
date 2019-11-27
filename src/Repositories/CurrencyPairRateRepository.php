<?php

namespace App\Repositories;

use App\Exceptions\UserRequestErrorException;
use App\Models\Currency;
use App\Repositories\Interfaces\CurrencyPairRateRepositoryInterface;
use GuzzleHttp\Client;
use Symfony\Component\HttpFoundation\Response;


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

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Возврщает курс обмена для пар.
     * @param Currency $from
     * @param Currency $to
     * @return float
     * //@throws UserRequestErrorException
     * @todo Тут вобще код надо допеределывать, нужен клиент к СБРФ, Сущность Пар и т.д.
     * @todo этот код не для чтения :) он просто работает :)
     */
    public function getFor(Currency $from, Currency $to): float
    {
        $data = $this->client->get('https://www.cbr-xml-daily.ru/daily_json.js');

        if ($data->getStatusCode() != Response::HTTP_OK) {
            throw new UserRequestErrorException("CBR is unreachabled. Try again later.");
        }

        $USDToRUBRate = json_decode($data
            ->getBody()
            ->getContents()
        )->Valute->USD->Value;

        $RUBToUSD = 1 / $USDToRUBRate;

        if ($from->getCode() == 'USD' &&
            $to->getCode() == 'RUB') {
            return $USDToRUBRate;
        }
        if ($from->getCode() == 'RUB' &&
            $to->getCode() == 'USD') {
            return $RUBToUSD;
        }
        throw new UserRequestErrorException("Unknows Currency Pair.");
    }
}