<?php
$title = $data['title'];
$content = $data['content'];
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?></title>
    <link href="css/normalize.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>
<body>

<?= Template::render('views/partials/header.php', $content['models']) ?>
<?= Template::render($content['path'], $content['models']) ?>
<?= Template::render('views/partials/footer.php', $content['models']) ?>

</body>
</html>