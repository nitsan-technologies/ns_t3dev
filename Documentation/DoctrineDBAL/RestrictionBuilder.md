# Restriction builder

---
The restriction builder is called whenever a **SELECT** or **COUNT** query is executed using either `\TYPO3\CMS\Core\Database\Query\QueryBuilder` or `\TYPO3\CMS\Core\Database\Connection`. The QueryBuilder allows manipulation of those restrictions, while the simplified Connection class does not. When a query deals with multiple tables in a **join, restrictions** are added for all affected tables.


### List of restriction:

1. Delete restriction [deleted = 0]`\TYPO3\CMS\Core\Database\Query\Restriction\DeletedRestriction`
2. Hidden restriction [hidden = 0]`\TYPO3\CMS\Core\Database\Query\Restriction\HiddenRestriction`
3. Start time restriction [starttime]`\TYPO3\CMS\Core\Database\Query\Restriction\StartTimeRestriction`
4. End time restriction [endtime]`\TYPO3\CMS\Core\Database\Query\Restriction\EndTimeRestriction`
5. fe_group restriction `\TYPO3\CMS\Core\Database\Query\Restriction\FrontendGroupRestriction`
6. Root level restriction [pid = 0]`\TYPO3\CMS\Core\Database\Query\Restriction\RootlevelRestriction`

---
#### Example for how to use restrictions:

```php

use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Database\Query\QueryBuilder;
use TYPO3\CMS\Core\Database\Query\Restriction\DeletedRestriction;
use TYPO3\CMS\Core\Database\Query\Restriction\HiddenRestriction;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Persistence\QueryResultInterface;

/**
 * @param bool $includeHidden
 * @param bool $includeDeleted
 * @return QueryBuilder
 */
private function getQueryForProductList(bool $includeHidden = false, bool $includeDeleted = false): QueryBuilder
{
    $q = GeneralUtility::makeInstance(ConnectionPool::class)
        ->getQueryBuilderForTable(self::TABLE);

    if($includeHidden) {
        $q->getRestrictions()->removeByType(HiddenRestriction::class);
    }

    if($includeDeleted) {
        $q->getRestrictions()->removeByType(DeletedRestriction::class);
    }

    return  $q->from(self::TABLE)
        ->select('*');
}
```
