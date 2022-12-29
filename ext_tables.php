<?php
defined('TYPO3') || die();

(static function() {
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_nst3dev_domain_model_productarea', 'EXT:ns_t3dev/Resources/Private/Language/locallang_csh_tx_nst3dev_domain_model_productarea.xlf');
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_nst3dev_domain_model_productarea');
})();

if (TYPO3_MODE === 'BE') {
    $isVersion9Up = \TYPO3\CMS\Core\Utility\VersionNumberUtility::convertVersionNumberToInteger(TYPO3_version) >= 9000000;
    if (!array_key_exists('nitsan', $GLOBALS['TBE_MODULES']) || $GLOBALS['TBE_MODULES']['nitsan'] =='') {
        if (version_compare(TYPO3_branch, '8.0', '>=')) {
            if (!isset($GLOBALS['TBE_MODULES']['nitsan'])) {
                $temp_TBE_MODULES = [];
                foreach ($GLOBALS['TBE_MODULES'] as $key => $val) {
                    if ($key == 'web') {
                        $temp_TBE_MODULES[$key] = $val;
                        $temp_TBE_MODULES['nitsan'] = '';
                    } else {
                        $temp_TBE_MODULES[$key] = $val;
                    }
                }
                $GLOBALS['TBE_MODULES'] = $temp_TBE_MODULES;
                $GLOBALS['TBE_MODULES']['_configuration']['nitsan'] = [
                    'iconIdentifier' => 'module-nst3dev',
                    'labels' => 'LLL:EXT:ns_t3dev/Resources/Private/Language/BackendModule.xlf',
                    'name' => 'nitsan'
                ];
            }
        }
    }
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
        'NsT3dev',
        'nitsan', // Make module a submodule of 'nitsan'
        'migration', // Submodule key
        '', // Position
        [
            \NITSAN\NsT3dev\Controller\ProductAreaController::class => 'dashboard, executeMigration, specificGridMigrate, processMirgrate',
        ],
        [
            'access' => 'user,group',
            'icon'   => 'EXT:ns_t3dev/Resources/Public/Icons/ns_t3dev.svg',
            'labels' => 'LLL:EXT:ns_t3dev/Resources/Private/Language/locallang_t3dev.xlf',
            'navigationComponentId' => ($isVersion9Up ? 'TYPO3/CMS/Backend/PageTree/PageTreeElement' : 'typo3-pagetree'),
            'inheritNavigationComponentFromMainModule' => false
        ]
    );
    $GLOBALS['TCA']['tx_nst3dev_domain_model_productarea']['ctrl']['hideTable'] = 1;
}