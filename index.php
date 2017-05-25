<?php
require_once 'init.php';

$categoryModel = new CategoryModel();
$lotModel = new LotModel();
$userModel = new UserModel();

$content = [
    'path' => 'views/content/lots.php',
    'models' => [
        'categoryModel' => $categoryModel,
        'lotModel' => $lotModel,
        'userModel' => $userModel
    ]
];

echo Template::render('views/base.php', ['title' => 'Главная', 'content' => $content]);
