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
$newFields = [
    'featured_image' => [
        'exclude' => true,
        'label' => 'LLL:EXT:ns_t3dev/Resources/Private/Language/locallang.xlf:system_featured_image',
        'config' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig(
            'featured_image',
            [
                'appearance' => [
                    'createNewRelationLinkTitle' => 'LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:images.addFileReference',
                ],
                'overrideChildTca' => [
                    'types' => [
                        '0' => [
                            'showitem' => '--palette--;;filePalette',
                        ],
                        \TYPO3\CMS\Core\Resource\File::FILETYPE_TEXT => [
                            'showitem' => '--palette--;;filePalette',
                        ],
                        \TYPO3\CMS\Core\Resource\File::FILETYPE_IMAGE => [
                            'showitem' => '--palette--;;filePalette',
                        ],
                        \TYPO3\CMS\Core\Resource\File::FILETYPE_AUDIO => [
                            'showitem' => '--palette--;;filePalette',
                        ],
                        \TYPO3\CMS\Core\Resource\File::FILETYPE_VIDEO => [
                            'showitem' => '--palette--;;filePalette',
                        ],
                        \TYPO3\CMS\Core\Resource\File::FILETYPE_APPLICATION => [
                            'showitem' => '--palette--;;filePalette',
                        ],
                    ],
                ],
                'foreign_match_fields' => [
                    'fieldname' => 'featured_image',
                    'tablenames' => 'sys_category',
                    'table_local' => 'sys_file',
                ],
                'maxitems' => 1,
            ],
            $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext']
        ),
    ],
];

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('sys_category', $newFields);
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes('sys_category', 'featured_image', '', 'after:slug');
