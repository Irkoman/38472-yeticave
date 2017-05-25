<?php

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

    /**
     * @var string $name Будет использоваться конструктором
     */
    protected $name;

    /**
     * BaseModel constructor
     */
    public function __construct()
    {
        $finderName = $this->name . 'Finder';
        $recordName = $this->name . 'Record';
        $this->finder = new $finderName();
        $this->record = new $recordName();
    }
}
