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
$database->connect();
$categories = $database->select('SELECT * FROM category');

$form = new LotForm();

if ($form->isSubmitted()) {
  $form->validate();
  $errors = $form->getAllErrors();

  if ($form->isValid()) {
    $formdata = $form->getFormdata();
    $lot_file = $formdata['lot-file'];
    move_uploaded_file($lot_file['tmp_name'], 'img/' . $lot_file['name']);

    $data = [
      date('Y-m-d H:i:s', strtotime($formdata['lot-date'])),
      $formdata['category'],
      $user->getUserdata()['id'],
      $formdata['lot-name'],
      $formdata['message'],
      'img/' . $lot_file['name'],
      $formdata['lot-rate'],
      $formdata['lot-step']
    ];

    $sql = '
      INSERT INTO lot
      (date_add, date_close, category_id, user_id, title, description, image, initial_rate, rate_step, fav_count)
      VALUES (NOW(), ?, ?, ?, ?, ?, ?, ?, ?, 0)
    ';
    $lot_id = $database->insert($sql, $data);

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
