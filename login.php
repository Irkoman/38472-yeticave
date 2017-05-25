<?php
require_once 'init.php';

$categoryModel = new CategoryModel();
$userModel = new UserModel();
$formModel = new LoginForm();
$formModel->checkLoginForm();

$content = [
    'path' => 'views/content/login.php',
    'models' => [
        'categoryModel' => $categoryModel,
        'formModel' => $formModel,
        'userModel' => $userModel
    ]
];

echo Template::render('views/base.php', ['title' => 'Вход', 'content' => $content]);