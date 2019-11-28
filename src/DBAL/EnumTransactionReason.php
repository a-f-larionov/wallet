<?php

namespace App\DBAL;

use App\Exceptions\UserRequestErrorException;
use Doctrine\DBAL\Types\Type;
use Doctrine\DBAL\Platforms\AbstractPlatform;

/**
 * Class EnumTransactionReason
 * @package App\DBAL
 */
class EnumTransactionReason extends Type
{
    const ENUM_NAME = 'enum_transaction_reason';
    const ENUM_STOCK = 'stock';
    const ENUM_FUND = 'refund';

    /**
     * @var array
     */
    private static array $enums = [
        self::ENUM_FUND => self::ENUM_FUND,
        self::ENUM_STOCK => self::ENUM_STOCK,
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
            throw new UserRequestErrorException("Invalid transaction reason");
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