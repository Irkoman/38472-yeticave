<?php
require_once './functions.php';
require_once './data.php';

$errors = [];
$file = [];

if (isset($_POST)) {
  foreach ($_POST as $key => $value) {
    $_POST[$key] = htmlspecialchars($value, ENT_QUOTES);

    if (empty($value)) {
      $errors[$key] = 'Заполните это поле';
    }

    if (in_array($key, ['lot-rate', 'lot-step']) && !is_numeric($value)) {
      $errors[$key] = 'Здесь должно быть число';
    }

    if (in_array($key, ['lot-date']) && !validateDate($value)) {
      $errors[$key] = 'Некорректная дата';
    }
  }

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

<?php if (empty($_POST) || !empty($errors)): ?>
<?= includeTemplate('templates/add-lot.php', ['categories' => $categories, 'errors' => $errors, 'file' => $file]) ?>
<?php else: ?>
<?= includeTemplate('templates/main-lot.php', ['lot' => $lot, 'bets' => $bets]) ?>
<?php endif; ?>

<?= includeTemplate('templates/footer.php') ?>

</body>
</html>
