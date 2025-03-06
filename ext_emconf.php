<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'Powermail JIRA Base',
    'description' => 'Base extension - Post powermail form submissions as jira issues',
    'category' => 'misc',
    'author' => 'Thomas Rawiel',
    'author_email' => 'thomas.rawiel@gmail.com',
    'state' => 'beta',
    'clearCacheOnLoad' => 0,
    'version' => '1.3.0',
    'constraints' => [
        'depends' => [
            'typo3' => '12.0.0-12.99.99',
            'powermail' => '10.0.0-12.99.99',
            'extender' => '10.0.0-10.99.99',
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
];
