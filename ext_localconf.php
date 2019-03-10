<?php
defined('TYPO3_MODE') or die();

$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['ke_search']['registerIndexerConfiguration'][] =
    \Derhansen\SfEventMgtIndexer\Indexer\EventIndexer::class;

$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['ke_search']['customIndexer'][] =
    \Derhansen\SfEventMgtIndexer\Indexer\EventIndexer::class;
