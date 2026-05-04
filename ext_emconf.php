<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'Powermail JIRA Base',
    'description' => 'Base extension - Post powermail form submissions as jira issues',
    'category' => 'misc',
    'author' => 'Thomas Rawiel',
    'author_email' => 'thomas.rawiel@gmail.com',
    'state' => 'stable',
    'clearCacheOnLoad' => 0,
    'version' => '1.6.0',
    'constraints' => [
        'depends' => [
            'typo3' => '13.0.0-13.99.99',
            'powermail' => '13.0.0-13.99.99',
            'extender' => '10.0.0-11.99.99',
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
];
