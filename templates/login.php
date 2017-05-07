<?php
$errors = $data['errors'];
?>

<main>
  <nav class="nav">
    <ul class="nav__list container">
      <li class="nav__item">
        <a href="all-lots.html">Доски и лыжи</a>
      </li>
      <li class="nav__item">
        <a href="all-lots.html">Крепления</a>
      </li>
      <li class="nav__item">
        <a href="all-lots.html">Ботинки</a>
      </li>
      <li class="nav__item">
        <a href="all-lots.html">Одежда</a>
      </li>
      <li class="nav__item">
        <a href="all-lots.html">Инструменты</a>
      </li>
      <li class="nav__item">
        <a href="all-lots.html">Разное</a>
      </li>
    </ul>
  </nav>
  <form class="form container <?= !empty($errors) ? 'form--invalid' : '' ?>" action="login.php" method="post">
    <h2>Вход</h2>
    <div class="form__item <?= !empty($errors['email']) ? 'form__item--invalid' : '' ?>">
      <label for="email">E-mail*</label>
      <input id="email" type="text" name="email" value="<?= isset($_POST['email']) ? $_POST['email'] : '' ?>" placeholder="Введите e-mail">
      <span class="form__error"><?= !empty($errors['email']) ? $errors['email'] : '' ?></span>
    </div>
    <div class="form__item form__item--last <?= !empty($errors['password']) ? 'form__item--invalid' : '' ?>">
      <label for="password">Пароль*</label>
      <input id="password" type="text" name="password" placeholder="Введите пароль">
      <span class="form__error"><?= !empty($errors['password']) ? $errors['password'] : '' ?></span>
    </div>
    <button type="submit" class="button">Войти</button>
  </form>
</main>
