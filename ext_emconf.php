<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'ke_search indexer for sf_event_mgt',
    'description' => 'Indexer for ke_search which indexed sf_event_mgt records',
    'category' => 'plugin',
    'author' => 'Torben Hansen',
    'author_email' => 'torben@derhansen.com',
    'state' => 'stable',
    'uploadfolder' => '0',
    'createDirs' => '',
    'clearCacheOnLoad' => 0,
    'version' => '2.0.4',
    'constraints' => [
        'depends' => [
            'typo3' => '8.7.0-9.5.99',
            'ke_search' => '2.5.0-0.0.0',
            'sf_event_mgt' => '3.0.0-0.0.0',
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
];
