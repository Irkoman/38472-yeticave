<?php
namespace yeticave\models;

use yeticave\active_record\finder\UserFinder;
use yeticave\active_record\record\UserRecord;

/**
 * Class UserModel
 */
class UserModel extends BaseModel
{
    /**
     * @var array $userdata Ассоциативный массив с данными пользователя
     */
    public $userdata = [];

    /**
     * @var array $authErrors Ошибка аутентификации
     */
    public $authErrors = [];

    /**
     * User constructor
     * @param string $email Почта
     * @param string $password Пароль
     */
    public function __construct($email = null, $password = null)
    {
        $this->finder = new UserFinder();
        $this->record = new UserRecord();
        $this->recognizeUser($email, $password);
    }

    /**
     * На основе наличия почты и пароля, логинит или определяет
     * аутентифицированность
     * @return array|bool
     */
    public function recognizeUser($email, $password)
    {
        if ($email && $password) {
            $this->login($email, $password);
        } else {
            $this->isAuth();
        }
    }

    /**
     * Проверяет, что пользователь аутентифицирован
     * @return bool
     */
    public function isAuth()
    {
        if (isset($_SESSION['user'])) {
            $this->userdata = $_SESSION['user'];
            return true;
        }

        return false;
    }

    /**
     * Выполняет аутентификацию
     * @return array|bool
     */
    public function login($email, $password)
    {
        if ($userRecord = $this->finder->findUserByEmail($email)) {
            if (password_verify($password, $userRecord->password)) {
                $this->userdata = [
                    'id'       => $userRecord->id,
                    'email'    => $userRecord->email,
                    'password' => $userRecord->password,
                    'name'     => $userRecord->name,
                    'avatar'   => $userRecord->avatar,
                    'contact'  => $userRecord->contact,
                    'date_add' => $userRecord->date_add
                ];
                $_SESSION['user'] = $this->userdata;
                header('Location: /index.php');
                return $this->userdata;
            } else {
                $this->authErrors['password'] = 'Вы ввели неверный пароль';
            }
        } else {
            $this->authErrors['email'] = 'Пользователь не найден';
        }

        return false;
    }

    /**
     * Разлогинивает пользователя
     * @return void
     */
    public function logout()
    {
        unset($_SESSION['user']);
        header('Location: /index.php');
    }

    /**
     * Возвращает информацию о залогиненном пользователе
     * @return array
     */
    public function getUserdata()
    {
        return $this->userdata;
    }
}
