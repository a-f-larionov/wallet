<?php

namespace App\Controllers;

use App\DBAL\EnumTransactionType;
use App\Exceptions\UserRequestErrorException;
use App\Models\Money;
use App\Repositories\Interfaces\TransactionLogsRepositoryInterface;
use App\Repositories\Interfaces\WalletRepositoryInterface;
use App\Services\CurrencyConverter;
use App\Services\Interfaces\CurrencyConverterInterface;
use App\Views\WalletViews;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class WalletController
 * @package App\Controllers
 */
class WalletController extends BaseController
{
    /**
     * @var WalletRepositoryInterface
     */
    private WalletRepositoryInterface $walletRepository;

    /**
     * @var WalletViews
     */
    private WalletViews $walletViews;

    /**
     * WalletController constructor.
     * @param WalletRepositoryInterface $walletRepository
     * @param WalletViews $walletViews
     */
    public function __construct(WalletRepositoryInterface $walletRepository, WalletViews $walletViews)
    {
        $this->walletRepository = $walletRepository;
        $this->walletViews = $walletViews;
    }

    /**
     * Создает кошелек пользователя.
     * @param int $userId id пользователя
     * @param string $currencyCode код валюты: RUB, USD, ...
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function create(int $userId, string $currencyCode, EntityManagerInterface $em): Response
    {
        $wallet = $em->transactional(
            function () use ($userId, $currencyCode) {

                if ($this->walletRepository->existsByUserId($userId)) {
                    throw  new UserRequestErrorException("User already have a wallet.");
                }

                return $this->walletRepository->create($userId, $currencyCode);
            }
        );

        return $this->walletViews->getWalletResponse($wallet);
    }

    /**
     * Получить баланс кошелька
     * @param int $walletId id кошелька
     * @return Response
     */
    public function getBalance(int $walletId): Response
    {
        $wallet = $this->walletRepository->findById($walletId);

        return $this->walletViews->getBalanceResponse($wallet);
    }

    /**
     * Имзенить баланс кошелька
     * @param int $walletId id кошелька
     * @param string $type типа транзакции debit credit см. EnumTransactionType::$enums
     * @param string $sum сумма
     * @param string $currencyCode валюта RUB, USD, ...
     * @param string $reason причина транзакции fund, stock, см. EnumTransactionReason::$enums
     * @param EntityManagerInterface $em
     * @param TransactionLogsRepositoryInterface $logsRepository
     * @param CurrencyConverterInterface $converter
     * @return Response
     * @throws Exception
     */
    public function changeBalance(
        int $walletId,
        string $type,
        string $sum,
        string $currencyCode,
        string $reason,
        EntityManagerInterface $em,
        TransactionLogsRepositoryInterface $logsRepository,
        CurrencyConverterInterface $converter
    ): Response {

        $money = new Money($currencyCode, $sum);

        $wallet = $em->transactional(
            function () use ($walletId, $money, $type, $reason, $logsRepository, $converter) {

                $wallet = $this->walletRepository->findById($walletId);

                $converter->convertTo($money, $wallet->getMoney()->getCurrency());

                switch ($type) {
                    case EnumTransactionType::ENUM_DEBIT:
                        $wallet->getMoney()->addMoney($money);
                        break;
                    case EnumTransactionType::ENUM_CREDIT:
                        $wallet->getMoney()->withdraw($money);
                        break;
                }

                $logsRepository->add($wallet, $money, $type, $reason);

                return $wallet;
            });

        return $this->walletViews->getBalanceResponse($wallet);
    }
}