<?php
ini_set('display_errors', 0);
session_start();

require_once 'functions.php';
require_once 'classes/Database.php';
require_once 'classes/User.php';
require_once 'classes/Form/BaseForm.php';
require_once 'classes/Form/SignupForm.php';
require_once 'classes/Form/LoginForm.php';
require_once 'classes/Form/BetForm.php';
require_once 'classes/Form/LotForm.php';
require_once 'classes/ActiveRecord/Record/BaseRecord.php';
require_once 'classes/ActiveRecord/Record/UserRecord.php';
require_once 'classes/ActiveRecord/Record/CategoryRecord.php';
require_once 'classes/ActiveRecord/Record/LotRecord.php';
require_once 'classes/ActiveRecord/Record/BetRecord.php';
require_once 'classes/ActiveRecord/Finder/BaseFinder.php';
require_once 'classes/ActiveRecord/Finder/UserFinder.php';
require_once 'classes/ActiveRecord/Finder/CategoryFinder.php';
require_once 'classes/ActiveRecord/Finder/LotFinder.php';
require_once 'classes/ActiveRecord/Finder/BetFinder.php';

$categories = [];
?>
