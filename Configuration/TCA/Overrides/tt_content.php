<?php
defined('TYPO3') || die();

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'NsT3dev',
    'Listing',
    'Listing'
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'NsT3dev',
    'Show',
    'Show/Detail'
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'NsT3dev',
    'Validation',
    'Validation'
);

$pluginSignature = str_replace('_', '', 'ns_t3dev') . '_listing';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue($pluginSignature, 'FILE:EXT:ns_t3dev/Configuration/FlexForms/FlexFormListing.xml');

$pluginSignature = str_replace('_', '', 'ns_t3dev') . '_show';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue($pluginSignature, 'FILE:EXT:ns_t3dev/Configuration/FlexForms/FlexFormDetails.xml');

