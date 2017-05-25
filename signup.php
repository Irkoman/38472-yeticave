<?php
require_once 'init.php';

$user = new User();

if ($user->isAuth()) {
    header('Location: /index.php');
}

$errors = [];
$avatar = '';

$database = new Database();

$categoryFinder = new CategoryFinder($database);
$categories = $categoryFinder->findCategories();

$form = new SignupForm();

if ($form->isSubmitted()) {
    $form->validate();
    $errors = $form->getAllErrors();
    $formdata = $form->getFormdata();

    if (!empty($formdata['email']) && $database->searchUserByEmail($formdata['email'])) {
        $errors['email'] = 'Указанный email уже используется другим пользователем';
    }

    if (!empty($formdata['avatar']['name'])) {
        $avatar = 'img/' . $formdata['avatar']['name'];
    }

    if ($form->isValid()) {
        $userRecord = new UserRecord($database);
        $userRecord->date_add = date("Y-m-d H:i:s");
        $userRecord->email = $formdata['email'];
        $userRecord->password = password_hash($formdata['password'], PASSWORD_DEFAULT);
        $userRecord->name = $formdata['name'];
        $userRecord->avatar = $avatar;
        $userRecord->contact = $formdata['message'];
        $userRecord->insert();

        header("Location: /");
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Регистрация</title>
    <link href="css/normalize.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>
<body>

<?= includeTemplate('templates/header.php') ?>
<?= includeTemplate('templates/signup.php', ['categories' => $categories, 'formdata' => $formdata, 'errors' => $errors]) ?>
<?= includeTemplate('templates/footer.php', ['categories' => $categories]) ?>

</body>
</html>
