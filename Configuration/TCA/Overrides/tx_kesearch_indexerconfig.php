<?php
defined('TYPO3_MODE') or die();

// enable "startingpoints_recursive" field
$GLOBALS['TCA']['tx_kesearch_indexerconfig']['columns']['startingpoints_recursive']['displayCond'] .= ',sfeventmgt';

// enable "sysfolder" field
$GLOBALS['TCA']['tx_kesearch_indexerconfig']['columns']['sysfolder']['displayCond'] .= ',sfeventmgt';

// Add selection fields
$fields = [
    'index_extsfeventmgt_event_restriction' => [
        'exclude' => 0,
        'label' => 'LLL:EXT:sf_event_mgt_indexer/Resources/Private/Language/locallang_db.xlf:event_restriction',
        'displayCond' => 'FIELD:type:IN:sfeventmgt',
        'config' => [
            'type' => 'select',
            'renderType' => 'selectSingle',
            'items' => [
                [
                    'LLL:EXT:sf_event_mgt_indexer/Resources/Private/Language/locallang_db.xlf:event_restriction.items.0',
                    '0'
                ],
                [
                    'LLL:EXT:sf_event_mgt_indexer/Resources/Private/Language/locallang_db.xlf:event_restriction.items.1',
                    '1'
                ],
                [
                    'LLL:EXT:sf_event_mgt_indexer/Resources/Private/Language/locallang_db.xlf:event_restriction.items.2',
                    '2'
                ],
            ],
            'default' => 1,
            'size' => 1,
            'maxitems' => 1,
        ]
    ],
    'index_extsfeventmgt_category_mode' => [
        'exclude' => 0,
        'label' => 'LLL:EXT:sf_event_mgt_indexer/Resources/Private/Language/locallang_db.xlf:category_mode',
        'displayCond' => 'FIELD:type:IN:sfeventmgt',
        'config' => [
            'type' => 'select',
            'renderType' => 'selectSingle',
            'items' => [
                [
                    'LLL:EXT:sf_event_mgt_indexer/Resources/Private/Language/locallang_db.xlf:category_mode.items.0',
                    '0'
                ],
                [
                    'LLL:EXT:sf_event_mgt_indexer/Resources/Private/Language/locallang_db.xlf:category_mode.items.1',
                    '1'
                ],
            ],
            'default' => 1,
            'size' => 1,
            'maxitems' => 1,
        ]
    ],
    'index_extsfeventmgt_category_selection' => [
        'exclude' => 1,
        'label' => 'LLL:EXT:sf_event_mgt_indexer/Resources/Private/Language/locallang_db.xlf:categories',
        'displayCond' => 'FIELD:type:=:sfeventmgt',
        'config' => [
            'type' => 'select',
            'renderType' => 'selectTree',
            'treeConfig' => [
                'parentField' => 'parent',
            ],
            'foreign_table' => 'sys_category',
            'size' => 10,
            'minitems' => 0,
            'maxitems' => 20,
        ],
    ],
];

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('tx_kesearch_indexerconfig', $fields);
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes(
    'tx_kesearch_indexerconfig',
    'index_extsfeventmgt_event_restriction, index_extsfeventmgt_category_mode, index_extsfeventmgt_category_selection',
    '',
    ''
);
