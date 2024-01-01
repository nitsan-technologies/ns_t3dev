# Database (Doctrine DBAL)

Database queries in TYPO3 are done with an API based on Doctrine DBAL. The API is provided by the system extension core, which is always loaded and thus always available.Database queries in TYPO3 are done with an API based on Doctrine DBAL. The API is provided by the system extension core, which is always loaded and thus always available.

---
## Configuration

```mysql
'DB' => [
    'Connections' => [
        'Default' => [
            'dbname' => 'db',
            'driver' => 'mysqli',
            'host' => 'db',
            'password' => 'db',
            'port' => '3306',
            'user' => 'db',
        ],
    ],
],
```


---
## The ext\_tables.sql files

all data definition statements are stored in files named `ext_tables.sql`, which may exist in any extension.

```mysql
CREATE TABLE tx_nst3dev_domain_model_productarea
(
	name        varchar(255) NOT NULL DEFAULT '',
	image       int(11) unsigned NOT NULL DEFAULT '0',
	description text,
	slug        varchar(255) NOT NULL DEFAULT '',
	type        varchar(255) NOT NULL DEFAULT '',
);
```

The classes which take care of assembling the complete SQL data definition will compile all the CREATE TABLE statements for a given table and turn them into a single CREATE TABLE statement. If the table already exists, missing fields are isolated and ALTER TABLE statements are proposed instead.

>This means that as an extension developer you should always only have CREATE TABLE statements in your ext_tables.sql files, the system will handle them as needed.

---
## Different Class overview

Doctrine DBAL provides a set of PHP objects to represent, create and handle SQL queries and their results.

#### `TYPO3\CMS\Core\Database\Connection`

* This object represents a specific connection to one connected database. It provides "shortcut" methods for simple standard queries like **SELECT** or **UPDATE**. To create more complex queries, an instance of the QueryBuilder can be retrieved.

#### `TYPO3\CMS\Core\Database\ConnectionPool`

* The ConnectionPool is the main entry point for extensions to retrieve a specific connection over which to execute a query. Usually it is used to **return a Connection or a QueryBuilder object**.

#### `TYPO3\CMS\Core\Database\Query\Expression\ExpressionBuilder`

* The ExpressionBuilder object is used to model complex expressions. It is mainly used for **WHERE** and **JOIN conditions**.

#### `TYPO3\CMS\Core\Database\Query\QueryBuilder`

* With the help of the QueryBuilder one can create all sort of complex queries executed on a specific connection. It provides the main **CRUD methods for select(), delete()** and friends.

#### `TYPO3\CMS\Core\Database\Query\Restriction\...`

* Restrictions are a set of classes that add expressions like deleted=0 to a query, based on the TCA settings of a table. They automatically adds TYPO3-specific restrictions like **start time** and **end time**, as well as **deleted and hidden flags**. Further restrictions for language overlays and workspaces are available.

#### `Doctrine\DBAL\Driver\Statement`

* This result object is returned when a **SELECT** or **COUNT** query was executed. Single rows are returned as an array by calling **->fetchAssociative()** until the method returns false
---

## Examples for different Query with different classes:

* [ConnectionPool](ConnectionPool.md)
* [Query builder](QueryBuilder.md)
* [Expression builder](ExpressionBuilder.md)
* [Restriction builder](RestrictionBuilder.md)

---
### How to debug in SQL.

* getSql() and executeQuery() / executeStatement() can be used after each other during development to simplify debugging:

```php
$queryBuilder
    ->select('uid')
    ->from('tx_nst3dev_domain_model_productarea')
    ->where(
        $queryBuilder->expr()->eq(
            'name',
            $queryBuilder->createNamedParameter('product1')
        )
    );

debug($queryBuilder->getSql());
$result = $queryBuilder->executeQuery();
```
