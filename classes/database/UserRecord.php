<?php

/**
 * Class UserRecord
 * Класс для представления одной записи таблицы пользователей
 */
class UserRecord
{
    protected $tableName = 'user';

    /**
     * @var int $id Идентификатор пользователя
     */
    private $id;

    /**
     * @var string $email Почта
     */
    private $email;

    /**
     * @var string $password Пароль
     */
    private $password;

    /**
     * @var string $name Имя пользователя
     */
    private $name;

    /**
     * @var string $avatar Путь до изображения
     */
    private $avatar;

    /**
     * @var string $contact Контакты
     */
    private $contact;

    /**
     * @var string $date_add Дата добавления в таблицу
     */
    private $date_add;

    /**
     * Смена пароля
     * @param string $newPassword
     * @return bool
     */
    public function changePassword($newPassword)
    {

    }
}
