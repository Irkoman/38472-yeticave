<?php
require_once 'init.php';

use yeticave\services\Template;
use yeticave\models\CategoryModel;
use yeticave\models\UserModel;
use yeticave\models\BetModel;

$userModel = new UserModel();

if (!$userModel->isAuth()) {
    header("HTTP/1.1 403 Forbidden");
    header('Location: /403.php');
}

$categoryModel = new CategoryModel();
$betModel = new BetModel();

$content = [
    'path' => 'views/content/mylots.php',
    'models' => [
        'categoryModel' => $categoryModel,
        'userModel' => $userModel,
        'betModel' => $betModel
    ]
];

echo Template::render('views/base.php', ['title' => 'Мои ставки', 'content' => $content]);