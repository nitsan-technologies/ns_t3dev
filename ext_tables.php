<?php

use NITSAN\NsT3dev\Controller\Backend\BeProductAreaController;

defined('TYPO3') || die();

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_nst3dev_domain_model_productarea', 'EXT:ns_t3dev/Resources/Private/Language/locallang_csh_tx_nst3dev_domain_model_productarea.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_nst3dev_domain_model_productarea');

if (TYPO3 == 'BE') {
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
        'NITSAN.NsT3dev',
        'web', // Make module a submodule of 'nitsan'
        'productarea1', // Submodule key
        '', // Position
        [
            BeProductAreaController::class => 'list, show, new, edit, update, delete'
        ],
        [
            'access' => 'user,group',
            'icon' => 'EXT:ns_t3dev/ext_icon.svg',
            'labels' => 'LLL:EXT:ns_t3dev/Resources/Private/Language/locallang.xlf:tx_nst3dev_domain_model_productarea',
        ]
    );
}
