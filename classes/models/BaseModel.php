<?php
namespace yeticave\models;

/**
 * Class BaseModel
 */
abstract class BaseModel
{
    /**
     * @var BaseFinder $finder Объект для поиска данных
     */
    public $finder;

    /**
     * @var BaseRecord $record Объект для записи данных
     */
    public $record;
}
