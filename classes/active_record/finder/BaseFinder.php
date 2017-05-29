<?php
namespace yeticave\active_record\finder;

use yeticave\services\Database;

/**
 * Class BaseFinder
 * Класс для поиска записи по id или другому критерию
 * и преобразования её в объект типа BaseRecord
 */
abstract class BaseFinder
{
    /**
     * @var mysqli $database Объект класса Database
     */
    protected $database;

    /**
     * BaseFinder constructor
     * @param string $tableName
     * @param mysqli $database
     */
    public function __construct()
    {
        $this->database = Database::getInstance();
    }

    /**
     * Выполняет запрос на получение одной записи
     * @param $sql string Запрос
     * @param array $data Массив с данными для вставки в запрос
     * @return array|bool
     */
    public static function selectOne($sql, $data = [])
    {
        $database = Database::getInstance();
        $rows = $database->select($sql, $data);
        if ($rows) {
            return $rows[0];
        } else {
            return false;
        }
    }

    /**
     * Выполняет запрос на получение всех записей, соответствующих условию
     * @param $sql string Запрос
     * @param array $data Массив с данными для вставки в запрос
     * @return array
     */
    public static function selectAll($sql, $data = [])
    {
        $database = Database::getInstance();
        return $database->select($sql, $data);
    }
}
