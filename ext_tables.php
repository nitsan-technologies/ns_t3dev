<?php
defined('TYPO3') || die();

(static function() {
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_nst3dev_domain_model_productarea', 'EXT:ns_t3dev/Resources/Private/Language/locallang_csh_tx_nst3dev_domain_model_productarea.xlf');
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_nst3dev_domain_model_productarea');
})();

if (TYPO3_MODE === 'BE') {
    $reportController = 'Report';
    if (version_compare(TYPO3_branch, '10.0', '>=')) {
        $reportController = \NITSAN\NsT3dev\Controller\ProductAreaController::class;
    }
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
        'NITSAN.NsT3dev',
        'nitsan',
        't3dev',
        '',
        [
            $reportController => 'list, show, new, edit, update',
        ],
        [
            'access' => 'user,group',
            'icon'   => 'EXT:ns_t3dev/Resources/Public/Icons/ext_domain product.png',
            'labels' => 'LLL:EXT:ns_t3dev/Resources/Private/Language/locallang.xlf:module.name',
            'inheritNavigationComponentFromMainModule' => false
        ]
    );

    $GLOBALS['TCA']['tx_nsfeedback_domain_model_feedbacks']['ctrl']['hideTable'] = 1;
    $GLOBALS['TCA']['tx_nsfeedback_domain_model_report']['ctrl']['hideTable'] = 1;
}