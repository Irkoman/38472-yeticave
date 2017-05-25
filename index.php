<?php
require_once 'init.php';

$database = new Database();

$categoryFinder = new CategoryFinder($database);
$categories = $categoryFinder->findCategories();

$lotFinder = new LotFinder($database);
$lots = $lotFinder->findActualLots();
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
<?= includeTemplate('templates/lots.php', ['categories' => $categories, 'lots' => $lots]) ?>
<?= includeTemplate('templates/footer.php', ['categories' => $categories]) ?>

</body>
</html>
