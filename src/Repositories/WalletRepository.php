<?php

namespace App\Repositories;

use App\Exceptions\UserRequestErrorException;
use App\Models\Wallet;
use App\Repositories\Interfaces\WalletRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Exception;

/**
 * Class WalletRepository
 * @package App\Repositories
 */
class  WalletRepository implements WalletRepositoryInterface
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
     * @param int $userId
     * @return bool
     */
    public function existsByUserId(int $userId): bool
    {
        return (bool)$this->em
            ->getRepository(Wallet::class)
            ->count(['userId' => $userId]);
    }

    /**
     * @param int $id
     * @return Wallet
     * @throws UserRequestErrorException
     */
    public function findById(int $id): Wallet
    {
        /** @var Wallet $wallet */
        $wallet = $this->em
            ->find(Wallet::class, $id);

        if (is_null($wallet)) {
            throw new UserRequestErrorException("No wallet found.");
        }

        return $wallet;
    }

    /**
     * @param int $userId
     * @param string $currencyCode
     * @return Wallet
     * @throws Exception
     */
    public function create(int $userId, string $currencyCode): Wallet
    {
        $wallet = new Wallet($userId, $currencyCode);
        $this->em->persist($wallet);
        return $wallet;
    }
}