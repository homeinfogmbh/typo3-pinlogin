<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'PIN Authentication',
    'description' => '',
    'category' => 'templates',
    'constraints' => [
        'depends' => [
        ],
        'conflicts' => [
        ],
    ],
    'autoload' => [
        'psr-4' => [
            'Homeinfo\\Pinlogin\\' => 'Classes',
        ],
    ],
    'state' => 'stable',
    'uploadfolder' => 0,
    'createDirs' => '',
    'clearCacheOnLoad' => 1,
    'author' => 'HomeInfo',
    'author_email' => 'info@homeinfo.de',
    'author_company' => 'HomeInfo',
    'version' => '1.0.0',
];
