<?php
require_once './functions.php';
require_once './data.php';

session_start();

if (empty($_SESSION['user'])) {
  header("HTTP/1.1 403 Forbidden");
}

$my_bets = getMyBetsFromCookies();
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

<?php if (empty($_SESSION['user'])): ?>
<?= includeTemplate('templates/error-403.php') ?>
<?php else: ?>
<?= includeTemplate('templates/mylots.php', ['my_bets' => $my_bets, 'lots' => $lots]) ?>
<?php endif; ?>

<?= includeTemplate('templates/footer.php') ?>

</body>
</html>
