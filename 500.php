<?php
require_once 'init.php';

$content = [
    'path' => 'views/content/error.php',
    'models' => [
        'error' => [
            'title' => '500',
            'text' => 'Ошибка обработки запроса'
        ]
    ]
];

echo Template::render('views/base.php', ['title' => '500', 'content' => $content]);
