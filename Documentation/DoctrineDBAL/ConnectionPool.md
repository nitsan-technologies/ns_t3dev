# Connection pool

---

TYPO3's interface for executing queries via Doctrine DBAL starts with a request to the ConnectionPool for a QueryBuilder or a Connection object and passing the table name to be queried:

```php
<?php

declare(strict_types=1);

namespace NITSAN\NsT3dev\Domain\Repository;

use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;

class ProductAreaRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{
    private const TABLE = 'tx_nst3dev_domain_model_productarea';

    /**
     *
     * @return QueryBuilder
     */
    private function getQueryForProductList(): QueryBuilder
    {
        $q = GeneralUtility::makeInstance(ConnectionPool::class)
            ->getQueryBuilderForTable(self::TABLE);

        return  $q->from(self::TABLE)
            ->select('*');
    }
}
```
