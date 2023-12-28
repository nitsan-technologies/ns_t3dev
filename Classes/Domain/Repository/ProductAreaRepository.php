<?php

declare(strict_types=1);

namespace NITSAN\NsT3dev\Domain\Repository;

use Doctrine\DBAL\DBALException;
use Doctrine\DBAL\Driver\Exception;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\SysLog\Action as SystemLogGenericAction;
use TYPO3\CMS\Core\SysLog\Error as SystemLogErrorClassification;
use TYPO3\CMS\Core\SysLog\Type as SystemLogType;
use TYPO3\CMS\Core\Database\Query\QueryBuilder;
use TYPO3\CMS\Core\Database\Query\Restriction\DeletedRestriction;
use TYPO3\CMS\Core\Database\Query\Restriction\HiddenRestriction;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use TYPO3\CMS\Extbase\Persistence\QueryResultInterface;

/**
 * This file is part of the "T3 Dev" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * (c) 2022 Nilesh Malankiya <nilesh@nitsantech.com>, NITSAN Technologies
 */

/**
 * The repository for ProductAreas
 */
class ProductAreaRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{
    private const TABLE = 'tx_nst3dev_domain_model_productarea';
    protected $defaultOrderings = ['crdate' => QueryInterface::ORDER_DESCENDING];

    public function updateSysFileReferenceRecord(
        int $uid_local,
        int $uid_foreign,
        int $pid,
        string $table,
        string $field
    ) : void
    {
        $tableConnectionCategoryMM = GeneralUtility::makeInstance(ConnectionPool::class)
            ->getConnectionForTable('sys_file_reference');

        $sysFileReferenceData[$uid_local] = [
            'uid_local' => $uid_local,
            'uid_foreign' => $uid_foreign,
            'tablenames' => $table,
            'fieldname' => $field,
            'sorting_foreign' => 1,
            'pid' => $pid,
            'table_local' => 'sys_file'
        ];
        if (!empty($sysFileReferenceData)) {
            $tableConnectionCategoryMM->bulkInsert(
                'sys_file_reference',
                array_values($sysFileReferenceData),
                ['uid_local', 'uid_foreign', 'tablenames', 'fieldname', 'sorting_foreign', 'pid', 'table_local']
            );
        }

        $count = $this->getRefrenceImageCounts($uid_local, $uid_foreign, $field, $table);

        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable($table);
        $queryBuilder
            ->update($table)
            ->where(
                $queryBuilder->expr()->eq('uid',
                    $queryBuilder->createNamedParameter($uid_foreign, \PDO::PARAM_INT)))
            ->set($field, $count)
            ->execute();

    }

    public function getRefrenceImageCounts($ref, $uid_foreign, $field, $table)
    {
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)
            ->getQueryBuilderForTable('sys_file_reference');
        $lastRecord = $queryBuilder
            ->select('*')
            ->from('sys_file_reference')
            ->where(
                $queryBuilder->expr()->eq('uid_foreign', $queryBuilder->createNamedParameter($uid_foreign, \PDO::PARAM_INT)),
                $queryBuilder->expr()->eq('tablenames', $queryBuilder->createNamedParameter($table)),
                $queryBuilder->expr()->eq('fieldname', $queryBuilder->createNamedParameter($field)),
                $queryBuilder->expr()->eq('deleted', $queryBuilder->createNamedParameter(0, \PDO::PARAM_INT))
            )
            ->execute()
            ->fetchAllAssociative();
        return count($lastRecord);
    }

    public function getRecord($uid)
    {
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
    }

    public function generateErrorLog($userId,$logMessage,$workspace){

        $tableConnectionCategoryMM = GeneralUtility::makeInstance(ConnectionPool::class)
            ->getConnectionForTable('sys_log');


        $logdata[$userId] = [
            'userid' => $userId,
            'type' => SystemLogType::ERROR,
            'channel' => SystemLogType::toChannel(SystemLogType::ERROR),
            'action' => SystemLogGenericAction::UNDEFINED,
            'error' => SystemLogErrorClassification::SYSTEM_ERROR,
            'level' => SystemLogType::toLevel(SystemLogType::ERROR),
            'details_nr' => 0,
            'details' => str_replace('%', '%%', $logMessage),
            'IP' => (string)GeneralUtility::getIndpEnv('REMOTE_ADDR'),
            'tstamp' => $GLOBALS['EXEC_TIME'],
            'workspace' => $workspace,
        ];

        if (!empty($logdata)) {
            $tableConnectionCategoryMM->bulkInsert(
                'sys_log',
                array_values($logdata),
                ['userid', 'type', 'channel', 'action', 'error', 'level', 'details_nr', 'details', 'IP', 'tstamp', 'workspace']
            );
        }
    }

    /**
     * @param array $filterData
     * @return QueryResultInterface|array
     * @throws InvalidQueryException
     */
    public function findData(array $filterData): QueryResultInterface|array
    {
        $query = $this->createQuery();
        $constraints = [];

        if ($searchWord = $filterData['searchWord'] ?? '') {
            $constraints[] = $query->logicalOr([
                $query->like('name', '%' .$searchWord . '%'),
                $query->like('description', '%' . $searchWord . '%')
            ]);
        }

        if ($selectType = $filterData['selectType'] ?? '') {
            $constraints[] = $query->equals('type', $selectType);
        }

        $query->matching($query->logicalAnd($constraints));
        return $query->execute();
    }


    /**
     * @param array|null $filterData
     * @return array
     * @throws DBALException
     * @throws Exception
     */
    public function findDataWithQueryBuilder(array $filterData = null): array
    {
        $includeHidden = (bool)($filterData['hidden'] ?? false);
        $includeDeleted = (bool)($filterData['deleted'] ?? false);
        $query = $this->getQueryForProductList($includeHidden, $includeDeleted);

        if ($searchWord = $filterData['searchWord'] ?? '') {
            $whereExpressions = [
                $query->expr()->like('name', $query->createNamedParameter('%' . $query->escapeLikeWildcards($searchWord) . '%')),
                $query->expr()->like('description', $query->createNamedParameter('%' . $query->escapeLikeWildcards($searchWord) . '%')),
            ];
            $query->orWhere(...$whereExpressions);
        }

        if ($selectType = $filterData['selectType'] ?? '') {
            $query->andWhere($query->expr()->eq('type', $query->createNamedParameter($selectType)));
        }
        $query->orderBy('crdate', 'DESC');
        return $query->execute()->fetchAllAssociative();
    }

    /**
     * @param array|null $filterData
     * @return array|false
     * @throws DBALException
     * @throws Exception
     */
    public function countDataWithExpression(array $filterData = null): array|false
    {
        $includeHidden = (bool)($filterData['hidden'] ?? false);
        $includeDeleted = (bool)($filterData['deleted'] ?? false);
        $query = $this->getQueryForProductList($includeHidden, $includeDeleted);

        if ($searchWord = $filterData['searchWord'] ?? '') {
            $whereExpressions = [
                $query->expr()->like('name', $query->createNamedParameter($query->escapeLikeWildcards($searchWord) . '%')),
                $query->expr()->like('description', $query->createNamedParameter($query->escapeLikeWildcards($searchWord) . '%')),
            ];
            $query->orWhere(...$whereExpressions);
        }

        if ($selectType = $filterData['selectType'] ?? '') {
            $query->andWhere($query->expr()->eq('type', $query->createNamedParameter($selectType)));
        }

        return  $query->addSelectLiteral(
            $query->expr()->count('uid','countedData')
        )
            ->executeQuery()
            ->fetchAssociative();
    }


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
}
