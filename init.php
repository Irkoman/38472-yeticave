<?php
ini_set('display_errors', 0);
session_start();

require_once 'classes/models/BaseModel.php';
require_once 'classes/models/CategoryModel.php';
require_once 'classes/models/LotModel.php';
require_once 'classes/models/BetModel.php';
require_once 'classes/models/UserModel.php';

require_once 'classes/forms/BaseForm.php';
require_once 'classes/forms/SignupForm.php';
require_once 'classes/forms/LoginForm.php';
require_once 'classes/forms/BetForm.php';
require_once 'classes/forms/LotForm.php';

require_once 'classes/services/Database.php';
require_once 'classes/services/Template.php';
require_once 'classes/services/Formatter.php';

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
