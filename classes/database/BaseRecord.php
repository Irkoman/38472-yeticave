<?php

/**
 * Class BaseRecord
 */
abstract class BaseRecord
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
     * BaseRecord constructor
     * @param string $tableName
     * @param mysqli $database
     */
    public function __construct($database)
    {
        $this->database = $database;
    }

    /**
     * Магический метод для получения значения поля по его имени
     * @param string $name Имя поля
     * @return mixed|null
     */
    public function __get($name)
    {
        $result = $this->$name ?? null;
        return $result;
    }

    /**
     * Магический метод для записи значения в конкретное поле
     * @param string $name Имя поля
     * @param mixed|null $value Данные ддя записи
     * @return mixed|null
     */
    public function __set($name, $value)
    {
        if (property_exists($this, $name)) {
            $this->$name = $value;
        }
    }

    /**
     * Добавление новой записи в таблице
     * @return bool
     */
    public function insert()
    {

    }

    /**
     * Обновление существующей записи в таблице
     * @return bool
     */
    public function update()
    {

    }

    /**
     * Удаление записи из таблицы
     * @return bool
     */
    public function delete()
    {

    }
}
