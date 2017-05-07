<?php
require_once './functions.php';
require_once './data.php';

session_start();

if (empty($_SESSION['user'])) {
  header("HTTP/1.1 403 Forbidden");
}

$errors = [];
$file = [];

if (isset($_POST)) {
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
    $lot = [
      'title' => $_POST['lot-name'],
      'category' => $_POST['category'],
      'price' => $_POST["lot-rate"],
      'url' => 'img/' . $file['name'],
      'description' => $_POST['message']
    ];
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

<?php if (empty($_SESSION['user'])): ?>
<?= includeTemplate('templates/error-403.php') ?>
<?php elseif (empty($_POST) || !empty($errors)): ?>
<?= includeTemplate('templates/add.php', ['categories' => $categories, 'errors' => $errors, 'file' => $file]) ?>
<?php else: ?>
<?= includeTemplate('templates/lot.php', ['lot' => $lot, 'bets' => $bets]) ?>
<?php endif; ?>

<?= includeTemplate('templates/footer.php') ?>

</body>
</html>
