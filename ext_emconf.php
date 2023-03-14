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
    'version' => '3.0.2',
    'constraints' => [
        'depends' => [
            'typo3' => '11.5.0-11.5.99',
            'sf_event_mgt' => '6.0.0-6.99.99',
            'ke_search' => '4.0.0-4.99.99',
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
];
