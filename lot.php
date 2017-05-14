<?php
require_once './functions.php';
require_once './data.php';

session_start();

$id = intval($_GET['id']);
$lot = [];
$errors = [];
$my_bets = getMyBetsFromCookies();
$link = connectDb();

if (!$link) {
  print('Ошибка: ' . mysqli_connect_error());
} else {
  $sql = 'SELECT lot.id, lot.title, lot.description, lot.initial_rate, lot.image, category.name AS category
    FROM lot JOIN category ON lot.category_id = category.id
    WHERE lot.id ='
    . $id;
  $lot = selectData($link, $sql)[0];
}

if (empty($lot)) {
  header("HTTP/1.1 404 Not Found");
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

<?php if (!empty($lot)): ?>
<?= includeTemplate('templates/lot.php', ['lot' => $lot, 'bets' => $bets, 'errors' => $errors, 'show_bet_form' => !isAlreadyBetted($id, $my_bets)]) ?>
<?php else: ?>
<?= includeTemplate('templates/error-404.php') ?>
<?php endif; ?>

<?= includeTemplate('templates/footer.php') ?>

</body>
</html>
