<?php
/**
 * Class User
 */
class User {

  /**
   * @var array $userdata Ассоциативный массив с данными пользователя
   */
  public $userdata = [];

  /**
   * @var array $authErrors Ошибка аутентификации
   */
  public $authErrors = [];

  /**
   * @var database $database
   */
  private $database;

  /**
   * User constructor
   * @param database $database Объект класса Database
   * @param string $email Почта
   * @param string $password Пароль
   */
  public function __construct($database, $email = null, $password = null) {
    $this->database = $database;

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
  public function isAuth() {
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
  public function login($email, $password) {
    if ($user = $this->database->searchUserByEmail($email)) {
      if (password_verify($password, $user['password'])) {
        $this->userdata = $user;
        $_SESSION['user'] = $user;
        header('Location: /index.php');
        return $user;
      }
      else {
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
  public function logout() {
    unset($_SESSION['user']);
    header("Location: /index.php");
  }

  /**
   * Возвращает информацию о залогиненном пользователе
   * @return array
   */
  public function getUserdata() {
    return $this->userdata;
  }
}
