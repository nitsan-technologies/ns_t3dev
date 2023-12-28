<?php

use NITSAN\NsT3dev\Controller\ProductAreaController;
use TYPO3\CMS\Core\Imaging\IconRegistry;
use TYPO3\CMS\Core\Log\LogLevel;
use TYPO3\CMS\Core\Log\Writer\DatabaseWriter;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Utility\ExtensionUtility;

defined('TYPO3') || die();

(static function() {
    ExtensionUtility::configurePlugin(
        'NsT3dev',
        'Listing',
        [
            ProductAreaController::class => 'list, new, create, edit, update, delete'
        ],
        // non-cacheable actions
        [
            ProductAreaController::class => 'create, update, delete'
        ]
    );

    ExtensionUtility::configurePlugin(
        'NsT3dev',
        'Show',
        [
            ProductAreaController::class => 'show'
        ],
    );

    ExtensionUtility::configurePlugin(
        'NsT3dev',
        'Validation',
        [
            ProductAreaController::class => 'validation'
        ],
    );

    ExtensionManagementUtility::addPageTSConfig('<INCLUDE_TYPOSCRIPT: source="FILE:EXT:ns_t3dev/Configuration/PageTSconfig/setup.tsconfig">');


    // Set Plugin Icon
    $pluginsIdentifiers = [
        'ns_t3dev-plugin-listing',
        'ns_t3dev-plugin-show',
        'ns_t3dev-plugin-validation'

    ];
    $iconRegistry = GeneralUtility::makeInstance(IconRegistry::class);
    foreach ($pluginsIdentifiers as $identifier) {
        $iconRegistry->registerIcon(
            $identifier,
            \TYPO3\CMS\Core\Imaging\IconProvider\BitmapIconProvider::class,
            ['source' => 'EXT:ns_t3dev/Resources/Public/Icons/'.$identifier.'.png']
        );
    }



    $GLOBALS['TYPO3_CONF_VARS']['LOG']['NITSAN']['NsT3dev']['Controller']['writerConfiguration'] = [
        LogLevel::INFO => [
            DatabaseWriter::class => [
                'logTable' => 'tx_nst3dev_domain_model_log',
            ],
        ],
    ];
})();
