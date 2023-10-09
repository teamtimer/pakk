<?php

$urls = [
    '/pakk/readme' => [
        'controller' => 'App\\Controllers\\PakkController',
        'action' => 'readme'
    ],
];

$config = [
    'urls' => $urls
];

return $config;