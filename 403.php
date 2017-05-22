<?php
require_once 'init.php';
?>

<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <title>403</title>
  <link href="css/normalize.min.css" rel="stylesheet">
  <link href="css/style.css" rel="stylesheet">
</head>
<body>

<?= includeTemplate('templates/header.php') ?>

<div class="error">
  <h1 class="error__title">403</h1>
  <p>Добавлять лоты и участвовать в торгах<br>могут только зарегистрированные пользователи</p>
</div>

<?= includeTemplate('templates/footer.php') ?>

</body>
</html>
