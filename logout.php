<?php
require_once 'init.php';

use yeticave\models\UserModel;

$userModel = new UserModel();
$userModel->logout();
?>
