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
}
