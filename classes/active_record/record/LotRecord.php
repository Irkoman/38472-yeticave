<?php
namespace yeticave\active_record\record;

/**
 * Class LotRecord
 * Класс для представления одной записи таблицы лотов
 */
class LotRecord extends BaseRecord
{
    /**
     * @var int $id Идентификатор лота
     */
    public $id;

    /**
     * @var int $category_id Идентификатор категории
     */
    public $category_id;

    /**
     * @var int $user_id Идентификатор автора публикации
     */
    public $user_id;

    /**
     * @var int $winner_id Идентификатор победителя
     */
    public $winner_id;

    /**
     * @var string $date_add Дата добавления в таблицу
     */
    public $date_add;

    /**
     * @var string $date_add Дата закрытия лота
     */
    public $date_close;

    /**
     * @var string $title Название лота
     */
    public $title;

    /**
     * @var string $description Описание лота
     */
    public $description;

    /**
     * @var string $image Путь до изображения
     */
    public $image;

    /**
     * @var int $initial_rate Начальная ставка
     */
    public $initial_rate;

    /**
     * @var int $rate_step Шаг ставки
     */
    public $rate_step;

    /**
     * @var int $fav_count Число добавлений в избранное
     */
    public $fav_count;

    /**
     * Поля смежных таблиц
     */
    public $category_name;

    /**
     * @return string
     */
    protected function getTableName()
    {
        return 'lot';
    }
}
