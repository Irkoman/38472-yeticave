<?php

/**
 * Class UserRecord
 * Класс для представления одной записи таблицы пользователей
 */
class UserRecord extends BaseRecord
{
    /**
     * @var int $id Идентификатор пользователя
     */
    public $id;

    /**
     * @var string $email Почта
     */
    public $email;

    /**
     * @var string $password Пароль
     */
    public $password;

    /**
     * @var string $name Имя пользователя
     */
    public $name;

    /**
     * @var string $avatar Путь до изображения
     */
    public $avatar;

    /**
     * @var string $contact Контакты
     */
    public $contact;

    /**
     * @var string $date_add Дата добавления в таблицу
     */
    public $date_add;

    /**
     * @return string
     */
    protected function getTableName()
    {
        return 'user';
    }
}
