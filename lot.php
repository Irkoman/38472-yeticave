<?php
require_once './functions.php';
require_once './data.php';

session_start();

$id = $_GET['id'];

if (!isset($lots[$id])) {
  header("HTTP/1.1 404 Not Found");
} else {
  $lot = $lots[$id];
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <title><?= $lot['title'] ?></title>
  <link href="css/normalize.min.css" rel="stylesheet">
  <link href="css/style.css" rel="stylesheet">
</head>
<body>

<?= includeTemplate('templates/header.php') ?>

<?php if (isset($lots[$id])): ?>
<?= includeTemplate('templates/lot.php', ['lot' => $lot, 'bets' => $bets]) ?>
<?php else: ?>
<?= includeTemplate('templates/error-404.php') ?>
<?php endif; ?>

<?= includeTemplate('templates/footer.php') ?>

</body>
</html>
