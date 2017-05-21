<?php
require_once './functions.php';

session_start();

$id = intval($_GET['id']);
$lot = [];
$bets = [];
$errors = [];
$my_bets = getMyBetsFromCookies();
$link = connectDb();

$sql = 'SELECT * FROM category';
$categories = selectData($link, $sql);

$sql = "SELECT lot.id, lot.title, lot.description, lot.initial_rate, lot.image, category.name AS category
  FROM lot JOIN category ON lot.category_id = category.id
  WHERE lot.id = $id";
$lot = selectData($link, $sql)[0];

$sql = "SELECT bet.date_add, bet.rate, user.name AS user
  FROM bet JOIN user ON bet.user_id = user.id
  WHERE bet.lot_id = $id ORDER BY bet.date_add DESC LIMIT 5";
$bets = selectData($link, $sql);

if (empty($lot)) {
  header("HTTP/1.1 404 Not Found");
  header("Location: /404.php");
}

if (isset($_POST['cost'])) {
  $errors = validateForm($_POST);

  if (empty($errors)) {
    $data = [
      $id,
      $_SESSION['user']['id'],
      date('Y-m-d H:i:s'),
      $_POST['cost']
    ];

    $my_bets[] = $data;
    setcookie("my_bets", json_encode($my_bets), strtotime("+1 month"));
    $sql = 'INSERT INTO bet (lot_id, user_id, date_add, rate) VALUES (?, ?, ?, ?)';
    $bet_id = insertData($link, $sql, $data);

    if ($bet_id) {
      header("Location: /mylots.php");
    } else {
      header('HTTP/1.1 500 Internal Server Error');
      header('Location: /500.php');
    }
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
<?= includeTemplate('templates/lot.php', ['categories' => $categories, 'lot' => $lot, 'bets' => $bets, 'errors' => $errors, 'show_bet_form' => !isAlreadyBetted($id, $my_bets)]) ?>
<?= includeTemplate('templates/footer.php', ['categories' => $categories]) ?>

</body>
</html>
