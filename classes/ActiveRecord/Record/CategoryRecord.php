<?php

/**
 * Class CategoryRecord
 * Класс для представления одной записи таблицы категорий
 */
class CategoryRecord extends BaseRecord
{
    /**
     * @var int $id Идентификатор категории
     */
    public $id;

    /**
     * @var string $name Имя категории
     */
    public $name;

    /**
     * @return string
     */
    protected function getTableName()
    {
        return 'category';
    }
}
