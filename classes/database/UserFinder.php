<?php

/**
 * Class UserFinder
 */
class UserFinder extends BaseFinder
{
    protected $tableName = 'user';

    /**
     * Поиск активных пользователей
     * @return UserRecord[] Массив объектов класса UserRecord
     */
    public function getActiveUsers()
    {

    }
}
