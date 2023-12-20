<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'T3 Dev',
    'description' => 'Master piece of all extensions for the references',
    'category' => 'example',
    'author' => 'Nilesh Malankiya',
    'author_email' => 'nilesh@nitsantech.com',
    'state' => 'experimental',
    'clearCacheOnLoad' => 0,
    'version' => '1.0.0',
    'constraints' => [
        'depends' => [
            'typo3' => '11.5.0-11.5.99',
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
];
