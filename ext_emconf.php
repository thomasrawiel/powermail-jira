<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'Powermail JIRA Base',
    'description' => 'Post powermail form submissions as jira issues',
    'category' => 'misc',
    'author' => 'Thomas Rawiel',
    'author_email' => 'thomas.rawiel@gmail.com',
    'state' => 'beta',
    'clearCacheOnLoad' => 0,
    'version' => '0.1.0',
    'constraints' => [
        'depends' => [
            'typo3' => '12.4.0-13.9.99',
            'powermail' => '10.0.0-12.99.99',
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
];
