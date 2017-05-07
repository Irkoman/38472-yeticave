<?php
$my_bets = $data['my_bets'];
$lots = $data['lots'];
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
  <section class="rates container">
    <h2>Мои ставки</h2>
    <table class="rates__list">
      <?php foreach ($my_bets as $my_bet): ?>
        <?php
          $lot = $lots[$my_bet['id']];
        ?>
        <tr class="rates__item">
          <td class="rates__info">
            <div class="rates__img">
              <img src="<?= $lot['url'] ?>" width="54" height="40" alt="<?= $lot['title'] ?>">
            </div>
            <h3 class="rates__title"><a href="lot.html"><?= $lot['title'] ?></a></h3>
          </td>
          <td class="rates__category">
            <?= $lot['category'] ?>
          </td>
          <td class="rates__timer">
            <div class="timer timer--finishing">07:13:34</div>
          </td>
          <td class="rates__price">
            <?= $my_bet['price'] . ' p.' ?>
          </td>
          <td class="rates__time">
            <?= formatTime($my_bet['time']) ?>
          </td>
        </tr>
      <?php endforeach; ?>
    </table>
  </section>
</main>
