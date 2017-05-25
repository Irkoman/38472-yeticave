<?php
require_once 'init.php';

$user = new User();

if (!$user->isAuth()) {
    header("HTTP/1.1 403 Forbidden");
    header('Location: /403.php');
}

$user_id = $user->getUserdata()['id'];
$my_bets = getMyBetsFromCookies();

$database = new Database();

$categoryFinder = new CategoryFinder($database);
$categories = $categoryFinder->findCategories();

$betFinder = new BetFinder($database);
$my_bets = $betFinder->findBetsByUser($user_id);
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Мои ставки</title>
    <link href="css/normalize.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>
<body>

<?= includeTemplate('templates/header.php') ?>
<?= includeTemplate('templates/mylots.php', ['categories' => $categories, 'my_bets' => $my_bets]) ?>
<?= includeTemplate('templates/footer.php', ['categories' => $categories]) ?>

</body>
</html>
