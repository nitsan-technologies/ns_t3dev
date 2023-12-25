<?php

declare(strict_types=1);

namespace NITSAN\NsT3dev\Domain\Repository;


use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;

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
}
