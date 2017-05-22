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
    public function __construct($database)
    {
        $this->database = $database;
    }

    /**
     * Поиск записи по её id
     * @param int $id Идентификатор
     * @return BaseRecord Объект класса BaseRecord
     */
    public function findById($id)
    {

    }

    /**
     * Поиск всех записей, отвечающих заданному условию
     * @param array $where Ассоциативный массив условия
     * @return BaseRecord[] Массив объектов класса BaseRecord
     */
    public function findAllBy($where = array())
    {
        $records = [];
        $sql = "SELECT * FROM $this->tableName";

        if ($where) {
            $sql .= " WHERE " . key($where) . " = ?";
        }

        $rows = $this->database->select($sql, $where);

        foreach ($rows as $row) {
            $className = ucfirst($this->tableName) . "Record";

            $record = new $className($this->database, $this->tableName);

//            foreach ($row as $key => $value) {
//                $record->key = $value;
//            }
//            var_dump($record);
            $records[] = $record;
        }

        return $records;
    }
}
