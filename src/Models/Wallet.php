<?php

namespace App\Models;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Embedded;
use Exception;

/**
 * Сущность кошельа
 * @ORM\Entity
 * @ORM\Table("wallet")
 * Class Wallet
 */
class Wallet
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     * @var int
     */
    private ?int  $id = null;

    /**
     * @ORM\Column(type="integer", unique=true, columnDefinition="integer unsigned")
     * @var int
     */
    private int $userId;

    /**
     * @Embedded(class="Money")
     * @var Money $money
     * @todo Can not be null! But issue opened https://github.com/doctrine/orm/issues/7854.
     */
    private ?Money $money = null;

    /**
     * Wallet constructor.
     * @param int $userId
     * @param string $currencyCode
     * @throws Exception
     */
    public function __construct(int $userId, string $currencyCode)
    {
        $this->userId = $userId;
        $this->money = new Money($currencyCode);
    }

    /**
     * @return int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * @return Money
     */
    public function getMoney(): Money
    {
        return $this->money;
    }
}