<?php
require_once 'init.php';

$user = new User();

if (!$user->isAuth()) {
  header("HTTP/1.1 403 Forbidden");
  header('Location: /403.php');
}

$user_id = $user->getUserdata()['id'];
$my_bets = getMyBetsFromCookies();

$database = new Database();
$database->connect();
$categories = $database->select('SELECT * FROM category');

$sql = '
  SELECT bet.lot_id, bet.date_add, bet.rate, lot.title AS lot_title, lot.image AS lot_image, lot.date_close AS lot_date_close, category.name AS category
  FROM bet
  JOIN lot ON lot.id = bet.lot_id
  JOIN category ON category.id = lot.category_id
  WHERE bet.user_id = ?
';
$my_bets = $database->select($sql, [$user_id]);
?>

<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <title>Мои ставки</title>
  <link href="css/normalize.min.css" rel="stylesheet">
  <link href="css/style.css" rel="stylesheet">
</head>
<body>

<?= includeTemplate('templates/header.php') ?>
<?= includeTemplate('templates/mylots.php', ['categories' => $categories, 'my_bets' => $my_bets]) ?>
<?= includeTemplate('templates/footer.php', ['categories' => $categories]) ?>

</body>
</html>
