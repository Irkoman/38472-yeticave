<?php
namespace yeticave\models;

/**
 * Class BaseModel
 */
abstract class BaseModel
{
    /**
     * @var *Finder $finder Объект для поиска данных
     */
    public $finder;

    /**
     * @var *Record $record Объект для записи данных
     */
    public $record;
}
