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

    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'NsT3dev',
        'ExampleForDBAL',
        [
            \NITSAN\NsT3dev\Controller\ProductAreaController::class => 'listForDatabase'
        ],
    );


    // Set Plugin Icon
    $pluginsIdentifiers = [
        'ns_t3dev-plugin-listing',
        'ns_t3dev-plugin-show',
        'ns_t3dev-plugin-validation',
        'ns_t3dev-plugin-ExampleForDBAL'

    ];
    $iconRegistry = GeneralUtility::makeInstance(IconRegistry::class);
    foreach ($pluginsIdentifiers as $identifier) {
        $iconRegistry->registerIcon(
            $identifier,
            \TYPO3\CMS\Core\Imaging\IconProvider\BitmapIconProvider::class,
            ['source' => 'EXT:ns_t3dev/Resources/Public/Icons/'.$identifier.'.png']
        );
    }

    $GLOBALS['TYPO3_CONF_VARS']['LOG']['NsT3dev']['ProductArea']['Controller']['writerConfiguration'] = [
        LogLevel::DEBUG => [
            DatabaseWriter::class => [
                'logTable' => 'tx_nst3dev_domain_model_log',
            ],
        ],
    ];

    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addService(
        'ns_t3dev', // Extension Key
        'auth' ,// Service type
        NITSAN\NsT3dev\Service\LoginAuthService::class ,// Service key
        array(
            'title' => 'Authentication for Login Service',
            'description' => 'Authentication for users',
            'subtype' => 'authUserFE,getUserFE',
            'available' => true,
            'priority' => 82, /* will be called before default typo3 authentication service */
            'quality' => 82,
            'os' => '',
            'exec' => '',
            'className' => NITSAN\NsT3dev\Service\LoginAuthService::class,
        )
    );
})();
