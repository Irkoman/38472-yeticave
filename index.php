<?php
require_once './functions.php';
require_once './data.php';

session_start();
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
