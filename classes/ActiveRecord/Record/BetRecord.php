<?php
namespace yeticave\ActiveRecord\Record;

/**
 * Class BetRecord
 * Класс для представления одной записи таблицы ставок
 */
class BetRecord extends BaseRecord
{
    /**
     * @var int $id Идентификатор ставки
     */
    public $id;

    /**
     * @var int $lot_id Идентификатор лота
     */
    public $lot_id;

    /**
     * @var int $user_id Идентификатор пользователя
     */
    public $user_id;

    /**
     * @var int $rate Сумма ставки
     */
    public $rate;

    /**
     * @var string $date_add Дата добавления в таблицу
     */
    public $date_add;

    /**
     * Поля смежных таблиц
     */
    public $user_name;
    public $lot_image;
    public $lot_title;
    public $lot_date_close;
    public $category_name;

    /**
     * @return string
     */
    protected function getTableName()
    {
        return 'bet';
    }
}
