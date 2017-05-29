<?php
namespace yeticave\active_record\finder;

use yeticave\active_record\record\UserRecord;

/**
 * Class UserFinder
 */
class UserFinder extends BaseFinder {

    /**
     * Поиск пользователя по email
     * @param string $email
     * @return UserRecord|bool Объект класса UserRecord
     */
    public function findUserByEmail($email)
    {
        $sql = 'SELECT * FROM user WHERE email = ? LIMIT 1';
        $row = $this->selectOne($sql, [$email]);

        if ($row) {
            $record = new UserRecord();
            return $record->fillRecord($row);
        }

        return false;
    }
}