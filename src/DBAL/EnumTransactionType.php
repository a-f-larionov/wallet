<?php

namespace App\DBAL;

use App\Exceptions\UserRequestErrorException;
use Doctrine\DBAL\Types\Type;
use Doctrine\DBAL\Platforms\AbstractPlatform;

/**
 * Class EnumTransactionType
 * @package App\DBAL
 */
class EnumTransactionType extends Type
{
    const ENUM_NAME = 'enum_transaction_type';
    const ENUM_DEBIT = 'debit';
    const ENUM_CREDIT = 'credit';

    /**
     * @var array
     */
    private static $enums = [
        self::ENUM_DEBIT => self::ENUM_DEBIT,
        self::ENUM_CREDIT => self::ENUM_CREDIT,
    ];

    /**
     * @param array $fieldDeclaration
     * @param AbstractPlatform $platform
     * @return string
     */
    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
    {
        $enums = array_map(function ($item) {
            return "'{$item}'";
        }, self::$enums);

        return "ENUM(" . join(',', $enums) . ")";
    }

    /**
     * @param mixed $value
     * @param AbstractPlatform $platform
     * @return mixed
     */
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return $value;
    }

    /**
     * @param mixed $value
     * @param AbstractPlatform $platform
     * @return mixed
     * @throws UserRequestErrorException
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if (!in_array($value, self::$enums)) {
            throw new UserRequestErrorException("Invalid transaction type");
        }
        return $value;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return self::ENUM_NAME;
    }

    /**
     * @param AbstractPlatform $platform
     * @return bool
     */
    public function requiresSQLCommentHint(AbstractPlatform $platform)
    {
        return true;
    }
}