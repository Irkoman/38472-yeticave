<?php
require_once 'init.php';

use yeticave\services\Template;
use yeticave\models\CategoryModel;
use yeticave\models\UserModel;
use yeticave\forms\SignupForm;

$userModel = new UserModel();

if ($userModel->isAuth()) {
    header('Location: /index.php');
}

$categoryModel = new CategoryModel();
$formModel = new SignupForm();
$formModel->handleSignupForm();

$content = [
    'path' => 'views/content/signup.php',
    'models' => [
        'categoryModel' => $categoryModel,
        'formModel' => $formModel,
        'userModel' => $userModel
    ]
];

echo Template::render('views/base.php', ['title' => 'Регистрация', 'content' => $content]);