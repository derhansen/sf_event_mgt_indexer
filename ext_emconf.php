<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'ke_search indexer for sf_event_mgt',
    'description' => 'Indexer for ke_search which indexed sf_event_mgt records',
    'category' => 'plugin',
    'author' => 'Torben Hansen',
    'author_email' => 'torben@derhansen.com',
    'state' => 'stable',
    'internal' => '',
    'uploadfolder' => '0',
    'createDirs' => '',
    'clearCacheOnLoad' => 0,
    'version' => '1.0.2',
    'constraints' => [
        'depends' => [
            'typo3' => '7.6.0-8.7.99',
            'ke_search' => '2.0.0-0.0.0',
            'sf_event_mgt' => '1.0.0-0.0.0',
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
];
