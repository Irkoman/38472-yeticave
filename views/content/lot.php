<?php
$id = $data['id'];

$lotModel = $data['lotModel'];
$lot = $lotModel->finder->findLotById($id);

if (empty($lot)) {
    header("HTTP/1.1 404 Not Found");
    header("Location: /404.php");
}

$userModel = $data['userModel'];

$categoryModel = $data['categoryModel'];
$categories = $categoryModel->finder->findCategories();

$betModel = $data['betModel'];
$bets = $betModel->finder->findBetsByLot($id);

$my_bets = $betModel::getMyBetsFromCookies();
$show_bet_form = !$betModel::isAlreadyBetted($id, $my_bets);

$formModel = $data['formModel'];
$errors = $formModel->getAllErrors();
?>

<main>
    <nav class="nav">
        <ul class="nav__list container">
            <?php foreach ($categories as $category): ?>
                <li class="nav__item">
                    <a href="all-lots.html"><?= $category->name ?></a>
                </li>
            <?php endforeach; ?>
        </ul>
    </nav>
    <section class="lot-item container">
        <h2><?= $lot->title ?></h2>
        <div class="lot-item__content">
            <div class="lot-item__left">
                <div class="lot-item__image">
                    <img src="<?= $lot->image ?>" width="730" height="548" alt="">
                </div>
                <p class="lot-item__category">Категория: <span><?= $lot->category_name ?></span></p>
                <p class="lot-item__description"><?= $lot->description ?></p>
            </div>
            <div class="lot-item__right">
                <?php if ($userModel->isAuth()): ?>
                    <div class="lot-item__state">
                        <div class="lot-item__timer timer">
                            <?= Formatter::calculateRemainingTime($lot->date_close) ?>
                        </div>
                        <div class="lot-item__cost-state">
                            <div class="lot-item__rate">
                                <span class="lot-item__amount">Текущая цена</span>
                                <span class="lot-item__cost"><?= $lot->initial_rate ?></span>
                            </div>
                            <div class="lot-item__min-cost">
                                Мин. ставка <span>12 000 р</span>
                            </div>
                        </div>
                        <?php if ($show_bet_form): ?>
                            <form class="lot-item__form" action="<?= $_SERVER['REQUEST_URI'] ?>" method="post">
                                <p class="lot-item__form-item <?= !empty($errors['cost']) ? 'form__item--invalid' : '' ?>">
                                    <label for="cost">Ваша ставка</label>
                                    <span class="form__error"><?= $errors['cost'] ?></span>
                                    <input id="cost" type="number" name="cost" placeholder="12 000">
                                </p>
                                <button type="submit" class="button">Сделать ставку</button>
                            </form>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
                <div class="history">
                    <h3>История ставок (<span><?= count($bets) ?></span>)</h3>
                    <table class="history__list">
                        <?php foreach ($bets as $bet): ?>
                            <tr class="history__item">
                                <td class="history__name"><?= $bet->user_name ?></td>
                                <td class="history__price"><?= $bet->rate ?></td>
                                <td class="history__time"><?= Formatter::formatTime(strtotime($bet->date_add)) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
            </div>
        </div>
    </section>
</main>
