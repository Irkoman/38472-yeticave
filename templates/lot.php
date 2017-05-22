<?php
$lot = $data['lot'];
$bets = $data['bets'];
$errors = $data['errors'];
$show_bet_form = $data['show_bet_form'];
$categories = $data['categories'];
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
  <section class="lot-item container">
    <h2><?= $lot['title'] ?></h2>
    <div class="lot-item__content">
      <div class="lot-item__left">
        <div class="lot-item__image">
          <img src="<?= $lot['image'] ?>" width="730" height="548" alt="">
        </div>
        <p class="lot-item__category">Категория: <span><?= $lot['category'] ?></span></p>
        <p class="lot-item__description"><?= $lot['description'] ?></p>
      </div>
      <div class="lot-item__right">
      <?php if (isset($_SESSION['user'])): ?>
        <div class="lot-item__state">
          <div class="lot-item__timer timer">
            10:54:12
          </div>
          <div class="lot-item__cost-state">
            <div class="lot-item__rate">
              <span class="lot-item__amount">Текущая цена</span>
              <span class="lot-item__cost"><?= $lot['initial_rate'] ?></span>
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
              <td class="history__name"><?= $bet['user'] ?></td>
              <td class="history__price"><?= $bet['rate'] ?></td>
              <td class="history__time"><?= formatTime(strtotime($bet['date_add'])) ?></td>
            </tr>
            <?php endforeach; ?>
          </table>
        </div>
      </div>
    </div>
  </section>
</main>
