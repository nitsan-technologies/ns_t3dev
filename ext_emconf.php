<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'T3 Dev – Developer Reference Extension',
    'description' => 'A developer-centric TYPO3 extension built to serve as a reference for best practices and reusable code components during extension development.',
    'category' => 'example',
    'author' => 'Team T3Planet',
    'author_email' => 'info@t3planet.de',
    'author_company' => 'T3Planet',
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
