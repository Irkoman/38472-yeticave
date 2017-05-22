<?php
require_once './mysql_helper.php';

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

function searchUserByEmail($link, $email) {
  $result = null;
  $sql = "SELECT * FROM user WHERE email = ? LIMIT 1";
  $data = selectData($link, $sql, [$email]);

  if (isset($data[0])) {
    $result = $data[0];
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

function connectDb() {
  $link = mysqli_connect('localhost', 'root', '', 'yeticave');

  if (!$link) {
    header('HTTP/1.1 500 Internal Server Error');
    header('Location: /500.php');
  }

  return $link;
}

function selectData($link, $sql, $values = []) {
  $rows = [];
  $stmt = db_get_prepare_stmt($link, $sql, $values);
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);

  if ($result) {
    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
      $rows[] = $row;
    }
  }

  return $rows;
}

function insertData($link, $sql, $values = []) {
  $stmt = db_get_prepare_stmt($link, $sql, $values);
  mysqli_stmt_execute($stmt);
  $last_id = mysqli_insert_id($link);

  if ($last_id > 0) {
    return $last_id;
  } else {
    return false;
  }
}

function updateData($link, $table, $updates, $conditions) {
  $updatesToString = "";
  $conditionsToString = "";
  $values = [];

  foreach ($updates as $update) {
    foreach ($update as $column => $value) {
      $updatesToString .= "$column = ?, ";
      $values[] = mysqli_real_escape_string($link, $value);
    }
  }

  foreach ($conditions as $column => $value) {
    $conditionsToString .= "$column = ? AND ";
    $values[] = $value;
  }

  $updatesToString = substr($updatesToString, 0, -2);
  $conditionsToString = substr($conditionsToString, 0, -5);
  $sql = "UPDATE $table SET $updatesToString WHERE $conditionsToString;";

  $stmt = db_get_prepare_stmt($link, $sql, $values);
  mysqli_stmt_execute($stmt);
  $rows_count = mysqli_stmt_affected_rows($stmt);

  if ($rows_count > 0) {
    return $rows_count;
  } else {
    return false;
  }
}
