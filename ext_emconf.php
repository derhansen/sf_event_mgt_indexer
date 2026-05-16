<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'ke_search indexer for sf_event_mgt',
    'description' => 'Indexer for ke_search which indexed sf_event_mgt records',
    'category' => 'plugin',
    'author' => 'Torben Hansen',
    'author_email' => 'torben@derhansen.com',
    'state' => 'stable',
    'version' => '6.0.0',
    'constraints' => [
        'depends' => [
            'typo3' => '13.4.0-14.3.99',
            'sf_event_mgt' => '8.0.0-9.99.99',
            'ke_search' => '7.0.0-7.99.99',
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
];
