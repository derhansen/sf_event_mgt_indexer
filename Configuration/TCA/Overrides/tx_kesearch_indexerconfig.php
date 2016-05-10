<?php
defined('TYPO3_MODE') or die();

// enable "startingpoints_recursive" field
$GLOBALS['TCA']['tx_kesearch_indexerconfig']['columns']['startingpoints_recursive']['displayCond'] .= ',sfeventmgt';

// enable "sysfolder" field
$GLOBALS['TCA']['tx_kesearch_indexerconfig']['columns']['sysfolder']['displayCond'] .= ',sfeventmgt';
