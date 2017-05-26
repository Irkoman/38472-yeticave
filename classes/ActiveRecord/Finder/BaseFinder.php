<?php
namespace yeticave\ActiveRecord\Finder;

use yeticave\services\Database;

/**
 * Class BaseFinder
 * Класс для поиска записи по id или другому критерию
 * и преобразования её в объект типа BaseRecord
 */
abstract class BaseFinder
{
    /**
     * @var string $tableName Имя таблицы
     */
    protected $tableName;

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
        $this->database = new Database();
    }

    /**
     * Выполняет запрос на получение одной записи
     * @param $sql string Запрос
     * @param array $data Массив с данными для вставки в запрос
     * @return array|bool
     */
    public static function selectOne($sql, $data = [])
    {
        $database = new Database();
        return $database->select($sql, $data)[0];
    }

    /**
     * Выполняет запрос на получение всех записей, соответствующих условию
     * @param $sql string Запрос
     * @param array $data Массив с данными для вставки в запрос
     * @return array
     */
    public static function selectAll($sql, $data = [])
    {
        $database = new Database();
        return $database->select($sql, $data);
    }
}
