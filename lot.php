<?php
require_once 'init.php';

$id = intval($_GET['id']);
$categoryModel = new CategoryModel();
$userModel = new UserModel();
$lotModel = new LotModel();
$betModel = new BetModel();
$formModel = new BetForm();
$formModel->checkBetForm($id);

$content = [
    'path' => 'views/content/lot.php',
    'models' => [
        'id' => $id,
        'categoryModel' => $categoryModel,
        'lotModel' => $lotModel,
        'betModel' => $betModel,
        'formModel' => $formModel,
        'userModel' => $userModel
    ]
];

echo Template::render('views/base.php', ['title' => 'Лот №' . $id, 'content' => $content]);
