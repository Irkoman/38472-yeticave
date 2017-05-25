<?php
require_once 'init.php';

$userModel = new UserModel();

if (!$userModel->isAuth()) {
    header("HTTP/1.1 403 Forbidden");
    header('Location: /403.php');
}

$categoryModel = new CategoryModel();
$formModel = new LotForm();
$formModel->checkLotForm();

$content = [
    'path' => 'views/content/add.php',
    'models' => [
        'categoryModel' => $categoryModel,
        'formModel' => $formModel,
        'userModel' => $userModel
    ]
];

echo Template::render('views/base.php', ['title' => 'Добавление лота', 'content' => $content]);