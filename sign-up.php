<?php
require_once './functions.php';

$errors = [];
$avatar = '';
$link = connectDb();

$sql = 'SELECT * FROM category';
$categories = selectData($link, $sql);

if (isset($_POST)) {
  $errors = validateForm($_POST);

  if (!empty($_POST['email']) && searchUserByEmail($link, $_POST['email'])) {
    $errors['email'] = 'Указанный email уже используется другим пользователем';
  }

  if (!empty($_FILES['avatar']['type'])) {
    $file = $_FILES['avatar'];

    if ($file['type'] == 'image/jpeg') {
      move_uploaded_file($file['tmp_name'], 'img/' . $file['name']);
      $avatar = 'img/' . $file['name'];
    } else {
      $errors['avatar'] = 'Загрузите фото в формате jpeg';
    }
  } else {
    unset($errors['avatar']);
  }
}

if (!empty($_POST) && !$errors) {
  $data = [
    date('Y-m-d H:i:s'),
    $_POST['email'],
    password_hash($_POST['password'], PASSWORD_DEFAULT),
    $_POST['name'],
    $avatar,
    $_POST['message']
  ];

  $sql = '
    INSERT INTO user (date_add, email, password, name, avatar, contact)
    VALUES (?, ?, ?, ?, ?, ?)
  ';
  $user_id = insertData($link, $sql, $data);

  if ($user_id) {
    header("Location: /");
  } else {
    header('HTTP/1.1 500 Internal Server Error');
    header('Location: /500.php');
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
<?= includeTemplate('templates/sign-up.php', ['categories' => $categories, 'errors' => $errors]) ?>
<?= includeTemplate('templates/footer.php', ['categories' => $categories]) ?>

</body>
</html>
