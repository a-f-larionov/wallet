<?php

namespace App\Models;

use Doctrine\ORM\Mapping as ORM;
use Exception;

/**
 * @ORM\Entity
 * @ORM\Table("transaction_logs")
 * Class TransactionLogs
 * @package App\Models
 */
class TransactionLogs
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     * @var int
     * @todo Can not be null! But issue opened https://github.com/doctrine/orm/issues/7854.
     */
    private ?int $id = null;

    /**
     * Время транзакции
     * @ORM\Column(type="datetime")
     */
    private \DateTime $created;

    /**
     * id кошелька
     * @ORM\Column(type="integer")
     * @var int
     */
    private int $walletId;

    /**
     * @ORM\Column(type="enum_transaction_reason")
     * @var string
     */
    private string $reason;

    /**
     * Тип транзакции
     * @ORM\Column(type="enum_transaction_type")
     * @var string
     */
    private string $type;

    /**
     * Запрашиваемая сумма транзакции.
     * @ORM\Column(type="integer", columnDefinition="integer unsigned")
     * @var int
     */
    private int $sum;

    /**
     * Номер валюты согласно ISO 4217
     * @ORM\Column(type="integer", columnDefinition="integer unsigned")
     * @var int
     * @see https://ru.wikipedia.org/wiki/ISO_4217
     */
    private int $currencyNum;

    /**
     * TransactionLogs constructor.
     * @param $walletId
     * @param $currencyNum
     * @param $sum
     * @param $type
     * @param $reason
     * @throws Exception
     */
    public function __construct($walletId, $currencyNum, $sum, $type, $reason)
    {
        $this->created = new \DateTime('now');
        $this->walletId = $walletId;
        $this->sum = $sum;
        $this->currencyNum = $currencyNum;
        $this->type = $type;
        $this->reason = $reason;
    }
}