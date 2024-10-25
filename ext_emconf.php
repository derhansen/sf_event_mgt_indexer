<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'ke_search indexer for sf_event_mgt',
    'description' => 'Indexer for ke_search which indexed sf_event_mgt records',
    'category' => 'plugin',
    'author' => 'Torben Hansen',
    'author_email' => 'torben@derhansen.com',
    'state' => 'stable',
    'version' => '5.0.0',
    'constraints' => [
        'depends' => [
            'typo3' => '12.4.0-13.4.99',
            'sf_event_mgt' => '7.0.0-8.99.99',
            'ke_search' => '6.0.0-6.99.99',
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
];
