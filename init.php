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
require_once 'classes/database/BaseRecord.php';
require_once 'classes/database/UserRecord.php';
require_once 'classes/database/CategoryRecord.php';
require_once 'classes/database/LotRecord.php';
require_once 'classes/database/BetRecord.php';
require_once 'classes/database/BaseFinder.php';
require_once 'classes/database/UserFinder.php';
require_once 'classes/database/CategoryFinder.php';
require_once 'classes/database/LotFinder.php';
require_once 'classes/database/BetFinder.php';

$categories = [];
?>
