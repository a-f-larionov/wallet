<?php

namespace App\Repositories;

use App\Models\Money;
use App\Models\TransactionLogs;
use App\Models\Wallet;
use App\Repositories\Interfaces\TransactionLogsRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Exception;

/**
 * Class WalletRepository
 * @package App\Repositories
 */
class TransactionLogsRepository implements TransactionLogsRepositoryInterface
{
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $em;

    /**
     * WalletRepository constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @param Wallet $wallet
     * @param Money $money
     * @param string $type
     * @param string $reason
     * @throws Exception
     */
    public function add(Wallet $wallet, Money $money, string $type, string $reason)
    {
        $log = new TransactionLogs(
            $wallet->getId(),
            $money->getCurrency()->getNum(),
            $money->getAmount(),
            $type,
            $reason
        );
        $this->em->persist($log);
    }
}