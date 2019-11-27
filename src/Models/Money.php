<?php

namespace App\Models;

use App\Exceptions\UserRequestErrorException;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Embeddable;
use Doctrine\ORM\Mapping\Embedded;
use Exception;

/**
 * Class Money
 * @Embeddable
 * @package App\Models
 */
class Money
{
    /**
     * Сырое представление денег..
     * @Column(type = "integer", columnDefinition="integer unsigned")
     * @var $rawSum int
     */
    private int $rawSum;

    /**
     * @Embedded(class="Currency")
     * @var Currency|null
     */
    private ?Currency $currency = null;

    /**
     * Money constructor.
     * @param string $currencyCode
     * @param string $sum
     * @throws Exception
     */
    public function __construct(string $currencyCode, string $sum = '0')
    {
        if (!self::isValidSum($sum)) {
            throw new UserRequestErrorException("Wrong sum.");
        }
        $sum = self::getRawSumFromString($sum);
        if ($sum < 0) {
            throw new UserRequestErrorException("The balance can`t be zero.");
        }
        $this->currency = new Currency($currencyCode);
        $this->rawSum = $sum;
    }

    /**
     * Валидной считаем строку содержающую только цифы, и максимум одну точку.
     * @param string $sum
     * @return bool
     */
    private static function isValidSum(string $sum): bool
    {
        return (bool)preg_match(
            '/^\d+(\.\d{1,2})?$/',
            $sum);
    }

    /**
     * @return Currency
     */
    public function getCurrency(): Currency
    {
        return $this->currency;
    }

    /**
     * @param Currency $currency
     */
    public function setCurrency(Currency $currency)
    {
        $this->currency = $currency;
    }

    /**
     * @return int
     */
    public function getRawSum(): int
    {
        return $this->rawSum;
    }

    /**
     * @param int $rawSum
     */
    public function setRawSum(int $rawSum): void
    {
        $this->rawSum = $rawSum;
    }

    /**
     * Возвращает кол-во денег.
     * Это не сырой вид, а человекочитаемый.
     * @return string
     */
    public function getAmount(): string
    {
        return number_format($this->rawSum / 100, 2, '.', '');
    }

    /**
     * Добавляем переданные деньги к текущим.
     * Если надо конвертирует.
     * @param Money $money
     * @throws UserRequestErrorException
     */
    public function addMoney(Money $money)
    {
        if ($money->getCurrency()->getNum() != $this->currency->getNum()) {
            throw new UserRequestErrorException("Cant withdraw currency from another currency.");
        }

        $this->rawSum += $money->rawSum;

        if ($this->rawSum < 0) {
            throw new UserRequestErrorException("Balance cant be less then zero.");
        }
    }

    /**
     * Списывает переданные деньги из текущих.
     * Если надо, конвертирует.
     * @param Money $money
     * @throws UserRequestErrorException
     */
    public function withdraw(Money $money)
    {
        if ($money->getCurrency()->getNum() != $this->currency->getNum()) {
            throw new UserRequestErrorException("Cant withdraw currency from another currency.");
        }

        $this->rawSum -= $money->rawSum;

        if ($this->rawSum < 0) {
            throw new UserRequestErrorException("Balance cant be less then zero.");
        }
    }

    /**
     * Возвращает внутрений сурой вид валюты.
     * @param string $sum
     * @return float|int
     */
    private static function getRawSumFromString(string $sum)
    {
        return (float)$sum * 100;
    }
}