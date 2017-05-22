<?php

/**
 * Class CategoryRecord
 * Класс для представления одной записи таблицы категорий
 */
class CategoryRecord
{
    protected $tableName = 'category';

    /**
     * @var int $id Идентификатор категории
     */
    private $id;

    /**
     * @var string $name Имя категории
     */
    private $name;
}
