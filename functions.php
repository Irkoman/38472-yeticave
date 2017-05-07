<?php
function includeTemplate($path, $data = []) {
  if (!file_exists($path)) {
    return '';
  }

  array_walk_recursive($data, 'secureData');

  ob_start();
  include($path);
  $html = ob_get_clean();

  return $html;
}

function secureData(&$string) {
  $string = htmlspecialchars($string, ENT_QUOTES);
}

function calculateLotTime() {
  date_default_timezone_set('Europe/Moscow');

  $tomorrow = strtotime('tomorrow midnight');
  $now = time();

  return gmdate('H:i', $tomorrow - $now);
}

function formatTime(int $ts) {
  $time = time() - $ts;
  $timeInHours = $time / 3600;

  if ($timeInHours >= 24) {
    return date('d.m.y в H:i', $ts);
  } elseif ($timeInHours < 1) {
    return date('i минут назад', $time);
  } else {
    return date('G часов назад', $time);
  };
}

function validateDate($string) {
  $date = date_create($string);
  return $date && date_format($date, 'd.m.Y');
}

function validateForm($post) {
  $errors = [];

  foreach ($post as $key => $value) {
    $post[$key] = htmlspecialchars($value, ENT_QUOTES);

    if (empty($value)) {
      switch ($key) {
        case 'email':
          $errors[$key] = 'Введите e-mail';
          break;
        case 'password':
          $errors[$key] = 'Введите пароль';
          break;
        default:
          $errors[$key] = 'Заполните это поле';
        }
    } else {
      if ($key =='lot-date' && !validateDate($value)) {
        $errors[$key] = 'Некорректная дата';
      }

      if (in_array($key, ['lot-rate', 'lot-step', 'cost']) && !is_numeric($value)) {
        $errors[$key] = 'Здесь должно быть число';
      }
    }
  }

  return $errors;
}

function searchUserByEmail($email, $users) {
  $result = null;

  foreach ($users as $user) {
    if ($user['email'] == $email) {
      $result = $user;
      break;
    }
  }

  return $result;
}

function getMyBetsFromCookies() {
  $my_bets = [];

  if (isset($_COOKIE['my_bets'])) {
    $my_bets = json_decode($_COOKIE['my_bets'], true);
  }

  return $my_bets;
}

function isAlreadyBetted($id, $my_bets) {
  foreach ($my_bets as $my_bet) {
    if ($id == $my_bet['id']) {
      return true;
    }
  }

  return false;
}
?>
