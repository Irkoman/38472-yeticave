<?php
require_once 'init.php';

$id = intval($_GET['id']);
$my_bets = getMyBetsFromCookies();
$show_bet_form = !isAlreadyBetted($id, $my_bets);
$errors = [];

$database = new Database();

$categoryFinder = new CategoryFinder($database);
$categories = $categoryFinder->findCategories();

$lotFinder = new LotFinder($database);
$lot = $lotFinder->findLotById($id);

$betFinder = new BetFinder($database);
$bets = $betFinder->findBetsByLot($id);

if (empty($lot)) {
    header("HTTP/1.1 404 Not Found");
    header("Location: /404.php");
}

$form = new BetForm();
$user = new User();
$userdata = $user->getUserdata();

if ($form->isSubmitted()) {
    $form->validate();
    $errors = $form->getAllErrors();

    if ($form->isValid()) {
        $formdata = $form->getFormdata();

        $my_bets[] = [
            'date_add' => time(),
            'lot_id' => $id,
            'rate' => $formdata['cost']
        ];

        setcookie("my_bets", json_encode($my_bets), strtotime("+1 month"));

        $betRecord = new BetRecord($database);
        $betRecord->date_add = date("Y-m-d H:i:s");
        $betRecord->lot_id = $id;
        $betRecord->user_id = $userdata['id'];
        $betRecord->rate = $formdata['cost'];
        $betRecord->insert();

        header("Location: /mylots.php");
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title><?= $lot->title ?></title>
    <link href="css/normalize.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>
<body>

<?= includeTemplate('templates/header.php') ?>
<?= includeTemplate('templates/lot.php', [
    'categories' => $categories,
    'lot' => $lot,
    'bets' => $bets,
    'errors' => $errors,
    'show_bet_form' => $show_bet_form
]) ?>
<?= includeTemplate('templates/footer.php', ['categories' => $categories]) ?>

</body>
</html>
