<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'ke_search indexer for sf_event_mgt',
    'description' => 'Indexer for ke_search which indexed sf_event_mgt records',
    'category' => 'plugin',
    'author' => 'Torben Hansen',
    'author_email' => 'derhansen@gmail.com',
    'state' => 'stable',
    'internal' => '',
    'uploadfolder' => '0',
    'createDirs' => '',
    'clearCacheOnLoad' => 0,
    'version' => '1.0.0',
    'constraints' => [
        'depends' => [
            'typo3' => '7.6.0-7.6.99',
            'ke_search' => '2.0.0-0.0.0',
            'sf_event_mgt' => '1.0.0-0.0.0',
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
];
