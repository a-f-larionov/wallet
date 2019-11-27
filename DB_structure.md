
wallet;
+--------------------+------------------+------+-----+---------+----------------+
| Field              | Type             | Null | Key | Default | Extra          |
+--------------------+------------------+------+-----+---------+----------------+
| id                 | int(11)          | NO   | PRI | NULL    | auto_increment |
| userId             | int(10) unsigned | YES  | UNI | NULL    |                |
| money_rawSum       | int(10) unsigned | YES  |     | NULL    |                |
| money_currency_num | int(10) unsigned | YES  |     | NULL    |                |
+--------------------+------------------+------+-----+---------+----------------+
transaction_logs
+-------------+------------------------+------+-----+---------+----------------+
| Field       | Type                   | Null | Key | Default | Extra          |
+-------------+------------------------+------+-----+---------+----------------+
| id          | int(11)                | NO   | PRI | NULL    | auto_increment |
| created     | datetime               | NO   |     | NULL    |                |
| walletId    | int(11)                | NO   |     | NULL    |                |
| reason      | enum('fund','stock')   | NO   |     | NULL    |                |
| type        | enum('debit','credit') | NO   |     | NULL    |                |
| sum         | int(11) unsigned       | NO   |     | NULL    |                |
| currencyNum | int(11) unsigned       | NO   |     | NULL    |                |
+-------------+------------------------+------+-----+---------+----------------+
