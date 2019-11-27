<?php

namespace App\Providers;

use App\DBAL\EnumTransactionReason;
use App\DBAL\EnumTransactionType;
use App\Providers\Interfaces\ProviderInterface;
use Doctrine\DBAL\DBALException;
use Doctrine\DBAL\Logging\EchoSQLLogger;
use Doctrine\DBAL\Types\Type;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\Tools\Setup;
use Psr\Container\ContainerInterface;

/**
 * Class EntityManagerProvider
 * @package App\Providers
 */
class EntityManagerProvider implements ProviderInterface
{
    /**
     * @param ContainerInterface $container
     * @return EntityManager|mixed
     * @throws ORMException
     * @throws DBALException
     */
    public static function create(ContainerInterface $container): EntityManager
    {
        // Создадим простоую Doctrine ORM конфигурацию для анатаций.
        $isDevMode = true;
        $proxyDir = null;
        $cache = null;
        $useSimpleAnnotationReader = false;
        $config = Setup::createAnnotationMetadataConfiguration(
            array(__DIR__ . "/../../src"),
            $isDevMode,
            $proxyDir,
            $cache,
            $useSimpleAnnotationReader
        );
        // или, если мы хотим использовать xml\yaml
        //$config = Setup::createXMLMetadataConfiguration(array(__DIR__."/config/xml"), $isDevMode);
        //$config = Setup::createYAMLMetadataConfiguration(array(__DIR__."/config/yaml"), $isDevMode);

        // конфигурационный параметры базы данных
        $conn = config('entityManager');

        // получаем EntityManager
        $entityManager = EntityManager::create($conn, $config);

        // вывод SQL запросов для дебага и профилинга
        if ($conn['echoSQLLog']) {
            $sqlLogger = new EchoSQLLogger();
            $entityManager->getConfiguration()->setSQLLogger($sqlLogger);
            echo 'logs';
        }

        self::addTypes();

        return $entityManager;
    }

    /**
     * @throws DBALException
     */
    private static function addTypes()
    {
        Type::addType('enum_transaction_type', EnumTransactionType::class);
        Type::addType('enum_transaction_reason', EnumTransactionReason::class);
    }
}