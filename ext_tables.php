<?php
defined('TYPO3') || die();

(static function() {
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_nst3dev_domain_model_productarea', 'EXT:ns_t3dev/Resources/Private/Language/locallang_csh_tx_nst3dev_domain_model_productarea.xlf');
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_nst3dev_domain_model_productarea');
})();

$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['scheduler']['tasks']['NITSAN\\NsT3dev\\Task\\Task'] = [
    'extension' => 'ns_t3dev',
    'title' => 'Schedular for Import Data from CSV File to Page Table',
    'description' => 'Setup scheduler which can be not updated on given time line ',
    'additionalFields' => 'NITSAN\\NsT3dev\\Task\\NsT3devField',
];