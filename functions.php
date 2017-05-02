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
  $hoursPassed = (time() - $ts) / 3600;

  if ($hoursPassed >= 24) {
    return date('d.m.y в H:i', $ts);
  } elseif ($hoursPassed < 1) {
    return date('i минут назад');
  } else {
    return date('H часов назад');
  };
}

function validateDate($string) {
  $date = date_create($string);
  return $date && date_format($date, 'd.m.Y');
}
?>
