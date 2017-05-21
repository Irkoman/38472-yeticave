<?php
require_once './functions.php';
?>

<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <title>500</title>
  <link href="css/normalize.min.css" rel="stylesheet">
  <link href="css/style.css" rel="stylesheet">
</head>
<body>

<?= includeTemplate('templates/header.php') ?>

<div class="error">
  <h1 class="error__title">500</h1>
  <p>Ошибка обработки запроса</p>
</div>

<?= includeTemplate('templates/footer.php') ?>

</body>
</html>
