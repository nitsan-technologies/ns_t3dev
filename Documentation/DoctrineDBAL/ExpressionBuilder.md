# Expression builder

---

An instance of the ExpressionBuilder is retrieved from the QueryBuilder object:

```php
//Example:
if ($searchWord = $filterData['searchWord'] ?? '') {
    $whereExpressions = [
        $query->expr()->like('name', $query->createNamedParameter('%' . $query->escapeLikeWildcards($searchWord) . '%')),
        $query->expr()->like('description', $query->createNamedParameter('%' . $query->escapeLikeWildcards($searchWord) . '%')),
    ];
    $query->orWhere(...$whereExpressions);
}
```

### Comparisons
A set of methods to create various comparison expressions or SQL functions:

* `->eq($fieldName, $value)` "equal" comparison =
* `->neq($fieldName, $value)` "not equal" comparison !=
* `->lt($fieldName, $value)` "less than" comparison <
* `->lte($fieldName, $value)` "less than or equal" comparison <=
* `->gt($fieldName, $value)` "greater than" comparison >
* `->gte($fieldName, $value)` "greater than or equal" comparison >=
* `->isNull($fieldName)` "IS NULL" comparison
* `->isNotNull($fieldName)` "IS NOT NULL" comparison
* `->like($fieldName, $value)` "LIKE" comparison
* `->notLike($fieldName, $value)` "NOT LIKE" comparison
* `->in($fieldName, $valueArray)` "IN ()" comparison
* `->notIn($fieldName, $valueArray)` "NOT IN ()" comparison
* `->inSet($fieldName, $value)` "FIND_IN_SET('42', aField)" Find a value in a comma separated list of values
* `->notInSet($fieldName, $value)` "NOT FIND_IN_SET('42', aField)" Find a value not in a comma separated list of values
* `->bitAnd($fieldName, $value)` A bitwise AND operation &

Examples for Expression builders:
```php
// `bodytext` = 'foo' - string comparison
->eq('bodytext', $queryBuilder->createNamedParameter('foo'))

// `tt_content`.`bodytext` = 'foo'
->eq('tt_content.bodytext', $queryBuilder->createNamedParameter('foo'))

// `aTableAlias`.`bodytext` = 'foo'
->eq('aTableAlias.bodytext', $queryBuilder->createNamedParameter('foo'))

// `uid` = 42 - integer comparison
->eq('uid', $queryBuilder->createNamedParameter(42, \PDO::PARAM_INT))

// `uid` >= 42
->gte('uid', $queryBuilder->createNamedParameter(42, \PDO::PARAM_INT))

// `bodytext` LIKE 'lorem'
->like(
    'bodytext',
    $queryBuilder->createNamedParameter(
        $queryBuilder->escapeLikeWildcards('lorem')
    )
)

// `bodytext` LIKE '%lorem%'
->like(
    'bodytext',
    $queryBuilder->createNamedParameter(
        '%' . $queryBuilder->escapeLikeWildcards('lorem') . '%'
    )
)

// usergroup does not contain 42
->notInSet('usergroup', $queryBuilder->createNamedParameter('42'))

// use TYPO3\CMS\Core\Database\Connection;
// `uid` IN (42, 0, 44) - properly sanitized, mind the intExplode and PARAM_INT_ARRAY
->in(
    'uid',
    $queryBuilder->createNamedParameter(
        GeneralUtility::intExplode(',', '42, karl, 44', true),
        Connection::PARAM_INT_ARRAY
    )
)

// use TYPO3\CMS\Core\Database\Connection;
// `CType` IN ('media', 'multimedia') - properly sanitized, mind the PARAM_STR_ARRAY
->in(
    'CType',
    $queryBuilder->createNamedParameter(
        ['media', 'multimedia'],
        Connection::PARAM_STR_ARRAY
    )
)
```
