<?php
require_once 'init.php';

$user = new User();

if (!$user->isAuth()) {
    header('HTTP/1.1 403 Forbidden');
    header('Location: /403.php');
}

$errors = [];
$file = [];

$database = new Database();

$categoryFinder = new CategoryFinder($database);
$categories = $categoryFinder->findCategories();

$form = new LotForm();

if ($form->isSubmitted()) {
    $form->validate();
    $errors = $form->getAllErrors();
    $formdata = $form->getFormdata();

    if ($form->isValid()) {
        $lotRecord = new LotRecord($database);
        $lotRecord->date_add = date("Y-m-d H:i:s");
        $lotRecord->date_close = date('Y-m-d H:i:s', strtotime($formdata['lot-date']));
        $lotRecord->category_id = $formdata['category'];
        $lotRecord->user_id = $user->getUserdata()['id'];
        $lotRecord->title = $formdata['lot-name'];
        $lotRecord->description = $formdata['message'];
        $lotRecord->image = 'img/' . $formdata['lot-file']['name'];
        $lotRecord->initial_rate = $formdata['lot-rate'];
        $lotRecord->rate_step = $formdata['lot-step'];
        $lotRecord->fav_count = 0;
        $lotRecord->insert();

        header("Location: /lot.php?id=" . $lotRecord->id);
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Добавление лота</title>
    <link href="css/normalize.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>
<body>

<?= includeTemplate('templates/header.php') ?>
<?= includeTemplate('templates/add.php', ['categories' => $categories, 'errors' => $errors, 'formdata' => $formdata]) ?>
<?= includeTemplate('templates/footer.php', ['categories' => $categories]) ?>

</body>
</html>
