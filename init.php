<?php
ini_set('display_errors', 0);
session_start();

require_once 'functions.php';
require_once 'classes/Database.php';
require_once 'classes/User.php';
require_once 'classes/BaseForm.php';
require_once 'classes/SignupForm.php';
require_once 'classes/LoginForm.php';
require_once 'classes/BetForm.php';
require_once 'classes/LotForm.php';

$categories = [];
?>
