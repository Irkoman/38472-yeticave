<?php
require_once './functions.php';
require_once './data.php';

session_start();

$categories = [];
$lots = [];
$link = connectDb();

if (!$link) {
  print('Ошибка: ' . mysqli_connect_error());
} else {
  $sql = 'SELECT * FROM category';
  $categories = selectData($link, $sql);

  $sql = '
    SELECT lot.id, lot.title, lot.initial_rate, lot.image, category.name AS category
    FROM lot JOIN category ON lot.category_id = category.id
    WHERE lot.date_close > NOW() AND lot.winner_id IS NULL
    ORDER BY lot.date_add DESC LIMIT 6
  ';
  $lots = selectData($link, $sql);
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <title>Главная</title>
  <link href="css/normalize.min.css" rel="stylesheet">
  <link href="css/style.css" rel="stylesheet">
</head>
<body>

<?= includeTemplate('templates/header.php') ?>
<?= includeTemplate('templates/lots.php', ['categories' => $categories, 'lots' => $lots, 'lot_time_remaining' => calculateLotTime()]) ?>
<?= includeTemplate('templates/footer.php') ?>

</body>
</html>
