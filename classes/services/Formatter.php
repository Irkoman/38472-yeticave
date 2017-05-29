<?php
namespace yeticave\services;

/**
 * Class Formatter
 */
class Formatter
{
    /**
     * Помогает обезопасить данные, преобразуя специальные символы в HTML-сущности
     * @param mixed $data Данные, которые могут быть получены извне
     * @return string Безопасные данные
     */
    public static function secureData($data)
    {
        if (is_array($data)) {
            foreach ($data as $key => $value) {
                $data[$key] = self::secureData($value);
            }
            return $data;
        } elseif (is_string($data)) {
            return htmlspecialchars($data);
        }
    }

    /**
     * Подсчитывает время до закрытия лота
     * @param string $date_close Дата закрытия лота
     * @return string Время в правильном формате
     */
    public static function calculateRemainingTime($date_close)
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
        }
    }

    /**
     * Подсчитывает время, прошедшее с определённого момента
     * @param int $ts Timestamp
     * @return string Время в правильном формате
     */
    public static function formatTime(int $ts)
    {
        $time = time() - $ts;
        $time_in_hours = $time / 3600;

        if ($time_in_hours >= 24) {
            return date('d.m.y в H:i', $ts);
        }

        if ($time_in_hours < 1) {
            return date('i минут назад', $time);
        }

        return date('G часов назад', $time);
    }
}
