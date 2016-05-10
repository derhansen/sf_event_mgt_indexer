<?php
defined('TYPO3_MODE') or die();

$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['ke_search']['registerIndexerConfiguration'][] = 'EXT:sf_event_mgt_indexer/class.user_kesearchhooks.php:user_kesearchhooks';
$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['ke_search']['customIndexer'][] = 'EXT:sf_event_mgt_indexer/class.user_kesearchhooks.php:user_kesearchhooks';
