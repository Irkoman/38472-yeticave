<?php
require_once 'init.php';

use yeticave\services\Template;
use yeticave\models\CategoryModel;
use yeticave\models\UserModel;

$categoryModel = new CategoryModel();
$userModel = new UserModel();

$content = [
    'path' => 'views/content/error.php',
    'models' => [
        'categoryModel' => $categoryModel,
        'userModel' => $userModel,
        'error' => [
            'title' => '403',
            'text' => 'Добавлять лоты и участвовать в торгах<br>могут только зарегистрированные пользователи'
        ]
    ]
];

echo Template::render('views/base.php', ['title' => '403', 'content' => $content]);
