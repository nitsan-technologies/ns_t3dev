# Query builder

---
The query builder provides a set of methods to create queries programmatically.

* The query builder comes with a happy little list of small methods:
* Set type of query: **->select(), ->count(), ->update(), ->insert()** and **->delete()**
* Prepare WHERE conditions
* Manipulate default WHERE restrictions added by TYPO3 for ->select()
* Add **LIMIT, GROUP BY** and other SQL functions
* executeQuery() executes a SELECT query and returns a result, a \Doctrine\DBAL\Result object
* executeStatement() executes an **INSERT, UPDATE or DELETE** statement and returns the number of affected rows.

Most of the query builder methods provide a fluent interface, return an instance of the current query builder itself, and can be chained:

```php
//Example for how to use select:
$queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)
            ->getQueryBuilderForTable('sys_file_reference');
        $row = $queryBuilder
            ->select('*')
            ->from('tx_nst3dev_domain_model_productarea')
            ->where(
                $queryBuilder->expr()->eq('uid', $queryBuilder->createNamedParameter($uid, \PDO::PARAM_INT)),
            )
            ->execute()
            ->fetchAllAssociative();
        return count($row);
```

```php
//Example for insert:
$queryBuilder = $this->connectionPool->getQueryBuilderForTable('tt_content');
$affectedRows = $queryBuilder
    ->insert('tt_content')
    ->values([
        'bodytext' => 'lorem',
        'header' => 'dolor',
    ])
    ->executeStatement();
```

```php
//Example for how to use update:
$queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable($table);
        $queryBuilder
            ->update($table)
            ->where(
                $queryBuilder->expr()->eq('uid',
                    $queryBuilder->createNamedParameter($uid_foreign, \PDO::PARAM_INT)))
            ->set($field, $count)
            ->execute();
```

```php
//Example for count:
$query = GeneralUtility::makeInstance(ConnectionPool::class)
            ->getQueryBuilderForTable(self::TABLE);

return  $query->addSelectLiteral($query->expr()->count('uid','countedData'))
        ->executeQuery()
        ->fetchAssociative();
```

```php
//Example for orderBy:
$query->orderBy('crdate', 'DESC');
```



