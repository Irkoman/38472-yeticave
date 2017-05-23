<?php
$categories = $data['categories'];
$errors = $data['errors'];
?>

<main>
    <nav class="nav">
        <ul class="nav__list container">
            <?php foreach ($categories as $category): ?>
                <li class="nav__item">
                    <a href="all-lots.html"><?= $category['name'] ?></a>
                </li>
            <?php endforeach; ?>
        </ul>
    </nav>
    <form class="form container <?= !empty($errors) ? 'form--invalid' : '' ?>" action="signup.php" method="post"
          enctype="multipart/form-data">
        <h2>Регистрация нового аккаунта</h2>
        <div class="form__item <?= !empty($errors['email']) ? 'form__item--invalid' : '' ?>">
            <label for="email">E-mail*</label>
            <input id="email" type="text" name="email" value="<?= isset($_POST['email']) ? $_POST['email'] : '' ?>"
                   placeholder="Введите e-mail">
            <span class="form__error"><?= !empty($errors['email']) ? $errors['email'] : '' ?></span>
        </div>
        <div class="form__item <?= !empty($errors['password']) ? 'form__item--invalid' : '' ?>">
            <label for="password">Пароль*</label>
            <input id="password" type="text" name="password" placeholder="Введите пароль">
            <span class="form__error"><?= !empty($errors['password']) ? $errors['password'] : '' ?></span>
        </div>
        <div class="form__item <?= !empty($errors['name']) ? 'form__item--invalid' : '' ?>">
            <label for="name">Имя*</label>
            <input id="name" type="text" name="name" value="<?= isset($_POST['name']) ? $_POST['name'] : '' ?>"
                   placeholder="Введите имя">
            <span class="form__error"><?= !empty($errors['name']) ? $errors['name'] : '' ?></span>
        </div>
        <div class="form__item <?= !empty($errors['message']) ? 'form__item--invalid' : '' ?>">
            <label for="message">Контактные данные*</label>
            <textarea id="message" name="message" value="<?= isset($_POST['message']) ? $_POST['message'] : '' ?>"
                      placeholder="Напишите, как с вами связаться"></textarea>
            <span class="form__error"><?= !empty($errors['message']) ? $errors['message'] : '' ?></span>
        </div>
        <div class="form__item form__item--file form__item--last">
            <label>Изображение</label>
            <div class="preview">
                <button class="preview__remove" type="button">x</button>
                <div class="preview__img">
                    <img src="<?= empty($errors['avatar']) && !empty($file['tmp_name']) ? '../img/' . $file['name'] : '' ?>"
                         width="113" height="113" alt="Аватар">
                </div>
            </div>
            <div class="form__input-file">
                <input class="visually-hidden" type="file" name="avatar" id="photo2" value="">
                <label for="photo2">
                    <span>+ Добавить</span>
                </label>
            </div>
        </div>
        <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>
        <button type="submit" class="button">Зарегистрироваться</button>
        <a class="text-link" href="login.php">Уже есть аккаунт</a>
    </form>
</main>
