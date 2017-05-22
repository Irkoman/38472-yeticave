<?php

/**
 * Class BetRecord
 * Класс для представления одной записи таблицы ставок
 */
class BetRecord
{
    protected $tableName = 'bet';

    /**
     * @var int $id Идентификатор ставки
     */
    private $id;

    /**
     * @var int $lot_id Идентификатор лота
     */
    private $lot_id;

    /**
     * @var int $user_id Идентификатор пользователя
     */
    private $user_id;

    /**
     * @var int $rate Сумма ставки
     */
    private $rate;

    /**
     * @var string $date_add Дата добавления в таблицу
     */
    private $date_add;
}
