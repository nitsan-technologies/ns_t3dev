<?php

declare(strict_types=1);

/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

namespace NITSAN\NsT3dev\Domain\Finishers;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Form\Domain\Finishers\AbstractFinisher;
use TYPO3\CMS\Form\Domain\Finishers\Exception\FinisherException;

class SavedataFinisher extends AbstractFinisher
{
   
    /**
     * Executes this finisher
     *
     * @see AbstractFinisher::execute()
     * @return string
     *
     * @throws FinisherException
     */
    protected function executeInternal()
    {
        
        $getFormValues = $this->finisherContext->getFormValues();
        $queryBuilder = GeneralUtility::makeInstance(\TYPO3\CMS\Core\Database\ConnectionPool::class)->getQueryBuilderForTable('tx_nst3dev_domain_model_productarea');

        $dataToInsert = [
            'name' => $getFormValues['text-1'],
            'description' => $getFormValues['textarea-1'],
        ];

        $queryBuilder
            ->insert('tx_nst3dev_domain_model_productarea')
            ->values($dataToInsert)
            ->execute();
    }

}
