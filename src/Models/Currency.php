<?php

namespace App\Models;

use App\Exceptions\UserRequestErrorException;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Embeddable;
use Exception;

/**
 * Сущность валюты на базе ISO 4218
 * @Embeddable
 * Class Currency
 * @package App\Models
 * @see https://ru.wikipedia.org/wiki/ISO_4217
 */
class Currency
{
    /**
     * Соответствия трехбуквенных кодов и номеров валют согласно ISO 4217
     * @see https://ru.wikipedia.org/wiki/ISO_4217
     * @var array
     */
    private static array $currencyCodeToNum = [
        'RUB' => 643,
        'USD' => 840,
    ];

    /**
     * Номер валюты согласно ISO 4217
     * @Column(type = "integer", columnDefinition="integer unsigned")
     * @var int
     */
    private int $num;

    /**
     * Currency constructor.
     * @param string $code
     * @throws Exception
     */
    public function __construct(string $code)
    {
        $this->num = self::getNumFromCode($code);
    }

    /**
     * Возвращает код валюты.
     * Согласно ISO 4217
     * @see https://ru.wikipedia.org/wiki/ISO_4217
     * @return string
     */
    public function getCode(): string
    {
        return array_search($this->num, self::$currencyCodeToNum);
    }

    /**
     * Возвращает номер валюты
     * Согласно ISO 4217
     * @see https://ru.wikipedia.org/wiki/ISO_4217
     * @return int
     */
    public function getNum(): int
    {
        return $this->num;
    }

    /**
     * @param string $code
     * @return mixed
     * @throws Exception
     */
    private static function getNumFromCode(string $code): int
    {
        if (!isset(self::$currencyCodeToNum[$code])) {
            throw new UserRequestErrorException("Wrong currency `$code`.");
        }

        return self::$currencyCodeToNum[$code];
    }
}