<?php
namespace yeticave\active_record\record;

use yeticave\services\Database;

/**
 * Class BaseRecord
 */
abstract class BaseRecord
{
    public $id;

    /**
     * «Магический» метод для получения значения поля по его имени
     * @param string $name Имя поля
     * @return mixed|null
     */
    public function __get($name)
    {
        return $this->$name ?? null;
    }

    /**
     * «Магический» метод для записи значения в конкретное поле
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
     * @param array $row Строка с данными
     * @return BaseRecord Объект BaseRecord с заполненными полями
     */
    public function fillRecord($row)
    {
        foreach ($row as $key => $value) {
            $this->$key = $value;
        }

        return $this;
    }

    /**
     * Добавление новой записи в таблицу
     */
    public function insert()
    {
        $values = [];
        $keys = [];

        foreach ($this as $key => $value) {
            if ($value) {
                $values[] = $value;
                $keys[] = "$key = ?";
            }
        }

        $sql  = 'INSERT INTO ' . $this->getTableName() . ' SET ' . implode(', ', $keys);

        $database = Database::getInstance();
        $this->id = $database->insert($sql, $values);
    }

    /**
     * Обновление существующей записи в таблице
     * @return bool
     */
    public function update()
    {
        $values = [];

        foreach ($this as $key => $value) {
            if ($key != 'id' && $value) {
                $values[$key] = $value;
            }
        }

        $database = Database::getInstance();
        return $database->update($this->getTableName(), $values, ['id' => $this->id]);
    }

    /**
     * Удаление записи из таблицы
     * @return bool
     */
    public function delete()
    {
        $database = Database::getInstance();
        return $database->delete($this->getTableName(), ['id' => $this->id]);
    }

    abstract protected function getTableName();
}
