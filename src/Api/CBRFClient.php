<?php

namespace App\Api;

use App\Exceptions\UserRequestErrorException;
use GuzzleHttp\Client;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class CBRFClient
 * @package App\API
 */
class CBRFClient
{
    /**
     * @var Client
     */
    private Client $client;

    /**
     * CBRFClient constructor.
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @throws UserRequestErrorException
     */
    public function getRates(): array
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

        return [
            'USDToRUB' => $USDToRUBRate,
            'RUBToUSD' => $RUBToUSD,
        ];
    }
}