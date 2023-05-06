<?php
defined('TYPO3') || die();

(static function() {
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'NsT3dev',
        'Listing',
        [
            \NITSAN\NsT3dev\Controller\ProductAreaController::class => 'list, show, new, create, edit, update, delete'
        ],
        // non-cacheable actions
        [
            \NITSAN\NsT3dev\Controller\ProductAreaController::class => 'create, update, delete'
        ]
    );

    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'NsT3dev',
        'Show',
        [
            \NITSAN\NsT3dev\Controller\ProductAreaController::class => 'list, show, new, create, edit, update, delete'
        ],
        // non-cacheable actions
        [
            \NITSAN\NsT3dev\Controller\ProductAreaController::class => 'create, update, delete'
        ]
    );

    // wizards
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig(
        'mod {
            wizards.newContentElement.wizardItems.plugins {
                elements {
                    listing {
                        iconIdentifier = ns_t3dev-plugin-listing
                        title = LLL:EXT:ns_t3dev/Resources/Private/Language/locallang_db.xlf:tx_ns_t3dev_listing.name
                        description = LLL:EXT:ns_t3dev/Resources/Private/Language/locallang_db.xlf:tx_ns_t3dev_listing.description
                        tt_content_defValues {
                            CType = list
                            list_type = nst3dev_listing
                        }
                    }
                    show {
                        iconIdentifier = ns_t3dev-plugin-show
                        title = LLL:EXT:ns_t3dev/Resources/Private/Language/locallang_db.xlf:tx_ns_t3dev_show.name
                        description = LLL:EXT:ns_t3dev/Resources/Private/Language/locallang_db.xlf:tx_ns_t3dev_show.description
                        tt_content_defValues {
                            CType = list
                            list_type = nst3dev_show
                        }
                    }
                }
                show = *
            }
       }'
    );
})();

//----------------------------------------------------------------------------------------------------------------------
// Database compare hide own tables
//----------------------------------------------------------------------------------------------------------------------
    // override connection migrator
    $GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects']['TYPO3\\CMS\\Core\\Database\\Schema\\ConnectionMigrator'] = [
        'className' => 'NITSAN\\NsT3dev\\Database\\Schema\\ConnectionMigrator'
    ];
//----------------------------------------------------------------------------------------------------------------------
    // Ignore tables with prefixes 
    $GLOBALS['TYPO3_CONF_VARS']['SYS']['DATABASE_COMPARE']['IGNORE_TABLE_PREFIXES'] = [
        'your_table_prefix',
    ];

    // Ignore individual table 
    $GLOBALS['TYPO3_CONF_VARS']['SYS']['DATABASE_COMPARE']['IGNORE_TABLE_NAMES'] = [
        'your_table_name',
    ];
//---------------------------------------------------------------------------------------------------------------------- 