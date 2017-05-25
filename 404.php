<?php
require_once 'init.php';

$categoryModel = new CategoryModel();
$userModel = new UserModel();

$content = [
    'path' => 'views/content/error.php',
    'models' => [
        'categoryModel' => $categoryModel,
        'userModel' => $userModel,
        'error' => [
            'title' => '404',
            'text' => 'Йети не нашёл такой страницы'
        ]
    ]
];

echo Template::render('views/base.php', ['title' => '404', 'content' => $content]);
