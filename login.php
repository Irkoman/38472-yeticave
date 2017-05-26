<?php
require_once 'init.php';

use yeticave\services\Template;
use yeticave\models\CategoryModel;
use yeticave\models\UserModel;
use yeticave\forms\LoginForm;

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