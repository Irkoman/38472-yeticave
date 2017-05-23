<?php
require_once 'init.php';
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>404</title>
    <link href="css/normalize.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>
<body>

<?= includeTemplate('templates/header.php') ?>

<div class="error">
    <h1 class="error__title">404</h1>
    <p>Йети не нашёл такой страницы</p>
</div>

<?= includeTemplate('templates/footer.php') ?>

</body>
</html>
