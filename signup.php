<?php
require_once 'init.php';

$user = new User();

if ($user->isAuth()) {
    header('Location: /index.php');
}

$errors = [];
$avatar = '';

$database = new Database();
$database->connect();
$categories = $database->select('SELECT * FROM category');

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
        $data = [
            $formdata['email'],
            password_hash($formdata['password'], PASSWORD_DEFAULT),
            $formdata['name'],
            $avatar,
            $formdata['message']
        ];

        $sql = '
      INSERT INTO user (date_add, email, password, name, avatar, contact)
      VALUES (NOW(), ?, ?, ?, ?, ?)
    ';
        $user_id = $database->insert($sql, $data);

        if ($user_id) {
            header("Location: /");
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
    <title>Регистрация</title>
    <link href="css/normalize.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>
<body>

<?= includeTemplate('templates/header.php') ?>
<?= includeTemplate('templates/signup.php', ['categories' => $categories, 'errors' => $errors]) ?>
<?= includeTemplate('templates/footer.php', ['categories' => $categories]) ?>

</body>
</html>
