## Wallet (демо-код)

Описание проекта: демо код АПИ Кошелька.

###### Функционал 
Создание, пополнение, списание, получение баланса кошелька.
Поддерживаемые валюты: USD, RUB

### АПИ Методы

1 - Создание кошелька [/createWallet/{userId}/{currency}](http://8ffd246e-5d74-49a5-8696-e92eff606a60.pub.cloud.scaleway.com/createWallet/1/RUB)

2 - Получение баланса [/getBalance/{walletId}](http://8ffd246e-5d74-49a5-8696-e92eff606a60.pub.cloud.scaleway.com/getBalance/1)

3 - Пополнение\Списание баланса [/changeBalance/{walletId}/{type}/{sum}/{currency}/{reason}](http://8ffd246e-5d74-49a5-8696-e92eff606a60.pub.cloud.scaleway.com/changeBalance/1/debit/12.12/USD/stock)

где: 
- userId - id пользователя, число;
- walletId -  id кошелька, число;
- type - тип транзакции, строка `debit` или `credit`;
- reason - причина транзакции, строка `fund` или `stock`;
- sum - сумма, число с плавающей точкой, до 2ух знаков;
- currency - валюта, строка `RUB`, `USD` согласно [ISO-4217](https://ru.wikipedia.org/wiki/ISO_4217)


### Инструкция по разветрыванию

`git clone https://github.com/a-f-larionov/wallet`

`composer install`

`vendor/bin/doctrine orm:schema-tool:create --force`

настраиваем nginx, проект готов. 
Можно использовать ссылке из этого документа, они ведут на настроенный проетк.



### Life Cycle:

- entry point /public/index.php;
- добавление зависимостей указанных в переменной providers массива файла конфигурации config.php;
- обработка роутинга на основе файла routes.php;


### Зависимости:

- php-di/php-di
- symfony/var-dumper
- symfony/http-foundation
- symfony/routing
- symfony/config
- doctrine/orm
- vlucas/phpdotenv
- guzzlehttp/guzzle

