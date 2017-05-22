<?php
require_once 'init.php';

$id = intval($_GET['id']);
$my_bets = getMyBetsFromCookies();
$show_bet_form = !isAlreadyBetted($id, $my_bets);
$errors = [];

$database = new Database();
$database->connect();
$categories = $database->select('SELECT * FROM category');

$sql = "SELECT lot.id, lot.title, lot.description, lot.initial_rate, lot.image, category.name AS category
  FROM lot JOIN category ON lot.category_id = category.id
  WHERE lot.id = $id";
$lot = $database->select($sql)[0];

$sql = "SELECT bet.date_add, bet.rate, user.name AS user
  FROM bet JOIN user ON bet.user_id = user.id
  WHERE bet.lot_id = $id ORDER BY bet.date_add DESC LIMIT 5";
$bets = $database->select($sql);

if (empty($lot)) {
    header("HTTP/1.1 404 Not Found");
    header("Location: /404.php");
}

$user = new User();
$userdata = $user->getUserdata();
$form = new BetForm();

if ($form->isSubmitted()) {
    $form->validate();
    $errors = $form->getAllErrors();

    if ($form->isValid()) {
        $formdata = $form->getFormdata();

        $data = [$id, $userdata['id'], $formdata['cost']];

        $my_bets[] = [
            'date_add' => time(),
            'lot_id' => $id,
            'rate' => $formdata['cost']
        ];

        setcookie("my_bets", json_encode($my_bets), strtotime("+1 month"));
        $sql = 'INSERT INTO bet (date_add, lot_id, user_id, rate) VALUES (NOW(), ?, ?, ?)';
        $bet_id = $database->insert($sql, $data);

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
