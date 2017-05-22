<?php

/**
 * Class LotRecord
 * Класс для представления одной записи таблицы лотов
 */
class LotRecord
{
    protected $tableName = 'lot';

    /**
     * @var int $id Идентификатор лота
     */
    private $id;

    /**
     * @var int $category_id Идентификатор категории
     */
    private $category_id;

    /**
     * @var int $user_id Идентификатор автора публикации
     */
    private $user_id;

    /**
     * @var int $winner_id Идентификатор победителя
     */
    private $winner_id;

    /**
     * @var string $date_add Дата добавления в таблицу
     */
    private $date_add;

    /**
     * @var string $date_add Дата закрытия лота
     */
    private $date_close;

    /**
     * @var string $title Название лота
     */
    private $title;

    /**
     * @var string $description Описание лота
     */
    private $description;

    /**
     * @var string $image Путь до изображения
     */
    private $image;

    /**
     * @var int $initial_rate Начальная ставка
     */
    private $initial_rate;

    /**
     * @var int $rate_step Шаг ставки
     */
    private $rate_step;

    /**
     * @var int $fav_count Число добавлений в избранное
     */
    private $fav_count;

    /**
     * Поля смежных таблиц
     */
    private $category_name;
    private $user_name;
}
