<?php
require_once 'init.php';

use yeticave\services\Template;
use yeticave\models\CategoryModel;
use yeticave\models\UserModel;
use yeticave\forms\LotForm;

$userModel = new UserModel();

if (!$userModel->isAuth()) {
    header("HTTP/1.1 403 Forbidden");
    header('Location: /403.php');
}

$categoryModel = new CategoryModel();
$formModel = new LotForm();
$formModel->handleLotForm();

$content = [
    'path' => 'views/content/add.php',
    'models' => [
        'categoryModel' => $categoryModel,
        'formModel' => $formModel,
        'userModel' => $userModel
    ]
];

echo Template::render('views/base.php', ['title' => 'Добавление лота', 'content' => $content]);