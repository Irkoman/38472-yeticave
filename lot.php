<?php
require_once './functions.php';
require_once './data.php';

session_start();

$id = $_GET['id'];
$errors = [];
$my_bets = getMyBetsFromCookies();

if (!isset($lots[$id])) {
  header("HTTP/1.1 404 Not Found");
} else {
  $lot = $lots[$id];
}

if (isset($_POST['cost'])) {
  $errors = validateForm($_POST);

  if (empty($errors)) {
    $my_bets[] = [
      'id'    => $id,
      'price' => $_POST['cost'],
      'time'  => time()
    ];

    setcookie("my_bets", json_encode($my_bets), strtotime("+1 month"));
    header("Location: /mylots.php");
  }
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
<?= includeTemplate('templates/lot.php', ['lot' => $lot, 'bets' => $bets, 'errors' => $errors, 'show_bet_form' => !isAlreadyBetted($id, $my_bets)]) ?>
<?php else: ?>
<?= includeTemplate('templates/error-404.php') ?>
<?php endif; ?>

<?= includeTemplate('templates/footer.php') ?>

</body>
</html>
