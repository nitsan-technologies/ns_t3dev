<?php
defined('TYPO3') || die();

(static function() {
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'NsT3dev',
        'Listing',
        [
            \NITSAN\NsT3dev\Controller\ProductAreaController::class => 'list, new, create, edit, update, delete'
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
            \NITSAN\NsT3dev\Controller\ProductAreaController::class => 'show'
        ],
    );

    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'NsT3dev',
        'Validation',
        [
            \NITSAN\NsT3dev\Controller\ProductAreaController::class => 'validation'
        ],
    );

    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig('<INCLUDE_TYPOSCRIPT: source="FILE:EXT:ns_t3dev/Configuration/PageTSconfig/setup.tsconfig">');


    // Set Plugin Icon
    $pluginsIdentifiers = [
        'ns_t3dev-plugin-listing',
        'ns_t3dev-plugin-show',
        'ns_t3dev-plugin-validation'

    ];
    $iconRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Imaging\IconRegistry::class);
    foreach ($pluginsIdentifiers as $identifier) {
        $iconRegistry->registerIcon(
            $identifier,
            \TYPO3\CMS\Core\Imaging\IconProvider\BitmapIconProvider::class,
            ['source' => 'EXT:ns_t3dev/Resources/Public/Icons/'.$identifier.'.png']
        );
    }

})();
