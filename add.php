<?php
require_once './functions.php';

session_start();

if (empty($_SESSION['user'])) {
  header('HTTP/1.1 403 Forbidden');
  header('Location: /403.php');
}

$errors = [];
$file = [];
$link = connectDb();

$sql = 'SELECT * FROM category';
$categories = selectData($link, $sql);

if (!empty($_POST)) {
  $errors = validateForm($_POST);

  if (isset($_FILES['lot-file'])) {
    $file = $_FILES['lot-file'];

    if ($file['type'] == 'image/jpeg') {
      move_uploaded_file($file['tmp_name'], 'img/' . $file['name']);
    } else {
      $errors['lot-file'] = 'Загрузите фото в формате jpeg';
    }
  }

  if (empty($errors)) {
    $data = [
      $_POST['category'],
      $_SESSION['user']['id'],
      date('Y-m-d H:i:s'),
      date('Y-m-d H:i:s', strtotime($_POST['lot-date'])),
      $_POST['lot-name'],
      $_POST['message'],
      'img/' . $file['name'],
      $_POST['lot-rate'],
      $_POST['lot-step'],
      0
    ];

    $sql = '
      INSERT INTO lot
      (category_id, user_id, date_add, date_close, title, description, image, initial_rate, rate_step, fav_count)
      VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
    ';
    $lot_id = insertData($link, $sql, $data);

    if ($lot_id) {
      header("Location: /lot.php?id=" . $lot_id);
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
  <title>Добавление лота</title>
  <link href="css/normalize.min.css" rel="stylesheet">
  <link href="css/style.css" rel="stylesheet">
</head>
<body>

<?= includeTemplate('templates/header.php') ?>
<?= includeTemplate('templates/add.php', ['categories' => $categories, 'errors' => $errors, 'file' => $file]) ?>
<?= includeTemplate('templates/footer.php', ['categories' => $categories]) ?>

</body>
</html>
