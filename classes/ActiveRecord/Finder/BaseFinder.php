<?php

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
     * @param string $className Имя класса
     * @param array $data Массив с данными для вставки в запрос
     * @return *Record|bool
     */
    public static function selectOne($sql, $className, $data = [])
    {
        $database = new Database();
        $row = $database->select($sql, $data)[0];

        if ($row) {
            $record = new $className($database);

            foreach ($row as $key => $value) {
                $record->$key = $value;
            }

            return $record;
        }

        return false;
    }

    /**
     * Выполняет запрос на получение всех записей, соответствующих условию
     * @param $sql string Запрос
     * @param string $className Имя класса
     * @param array $data Массив с данными для вставки в запрос
     * @return array Массив объектов класса *Record
     */
    public static function selectAll($sql, $className, $data = [])
    {
        $records = [];
        $database = new Database();
        $rows = $database->select($sql, $data);

        foreach ($rows as $row) {
            $record = new $className($database);

            foreach ($row as $key => $value) {
                $record->$key = $value;
            }

            $records[] = $record;
        }

        return $records;
    }
}
