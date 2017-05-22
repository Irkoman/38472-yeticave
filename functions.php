<?php
function includeTemplate($path, $data = [])
{
    if (!file_exists($path)) {
        return '';
    }

    array_walk_recursive($data, 'secureData');

    ob_start();
    include($path);
    $html = ob_get_clean();

    return $html;
}

function secureData(&$string)
{
    $string = htmlspecialchars($string, ENT_QUOTES);
}

function calculateRemainingTime($date_close)
{
    date_default_timezone_set('Europe/Moscow');

    $time = strtotime($date_close) - time();
    $time_in_hours = floor($time / 3600);

    if ($time < 0) {
        return 'Лот закрыт';
    } elseif ($time_in_hours >= 24) {
        return date('d дней', $time);
    } else {
        return date('H:i', $time);
    };
}

function formatTime(int $ts)
{
    $time = time() - $ts;
    $time_in_hours = $time / 3600;

    if ($time_in_hours >= 24) {
        return date('d.m.y в H:i', $ts);
    } elseif ($time_in_hours < 1) {
        return date('i минут назад', $time);
    } else {
        return date('G часов назад', $time);
    };
}

function getMyBetsFromCookies()
{
    $my_bets = [];

    if (isset($_COOKIE['my_bets'])) {
        $my_bets = json_decode($_COOKIE['my_bets'], true);
    }

    return $my_bets;
}

function isAlreadyBetted($lot_id, $my_bets)
{
    foreach ($my_bets as $my_bet) {
        if ($lot_id == $my_bet['lot_id']) {
            return true;
        }
    }

    return false;
}
