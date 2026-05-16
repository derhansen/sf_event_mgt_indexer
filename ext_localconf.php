<?php

defined('TYPO3') or die();

use Derhansen\SfEventMgtIndexer\Indexer\EventIndexer;

$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['ke_search']['registerIndexerConfiguration'][] = EventIndexer::class;

$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['ke_search']['customIndexer'][] = EventIndexer::class;
