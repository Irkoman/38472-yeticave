<?php
namespace yeticave\services;

/**
 * Class Database
 */
class Database
{
    /**
     * @var mysqli $link Ресурс соединения
     */
    private $link;

    /**
     * @var string $error Информация о последней ошибке
     */
    private $error = '';

    /**
     * Объект соединения
     */
    private static $instance;

    /**
     * Database constructor
     * Устанавливает соединение
     */
    private  function __construct()
    {
        $this->link = mysqli_connect('localhost', 'root', '', 'yeticave');

        if (!$this->link) {
            $this->error = mysqli_connect_error();
            header('HTTP/1.1 500 Internal Server Error');
            header('Location: /500.php');
        }
    }

    /**
     * Получает объект соединения, если он уже был создан.
     * Если нет - создаёт его.
     * @return Database
     */
    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new self;
        }

        return self::$instance;
    }

    /**
     * Возвращает информацию о последней ошибке
     * @return string
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * Создаёт подготовленное выражение
     * @param string $sql SQL-запрос с плейсхолдерами вместо значений
     * @param array $data Данные для вставки на место плейсхолдеров
     * @return mysqli_stmt Подготовленное выражение
     */
    public function getPrepareStmt($sql, $values = [])
    {
        $stmt = mysqli_prepare($this->link, $sql);

        if ($values) {
            $types = '';
            $stmt_data = [];

            foreach ($values as $value) {
                $type = null;

                if (is_int($value)) {
                    $type = 'd';
                } else {
                    if (is_string($value)) {
                        $type = 's';
                    } else {
                        if (is_double($value)) {
                            $type = 'd';
                        }
                    }
                }

                if ($type) {
                    $types .= $type;
                    $stmt_data[] = $value;
                }
            }

            $values = array_merge([$stmt, $types], $stmt_data);

            $func = 'mysqli_stmt_bind_param';
            $func(...$values);
        }

        return $stmt;
    }

    /**
     * Выполняет запрос на получение данных
     * @param string $sql Запрос
     * @param array $values Значения для подготовленного выражения
     * @return array
     */
    public function select($sql, $values = [])
    {
        $rows = [];
        $stmt = $this->getPrepareStmt($sql, $values);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($result) {
            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                $rows[] = $row;
            }
        }

        return $rows;
    }

    /**
     * Выполняет запрос на добавление новых данных
     * @param string $sql Запрос
     * @param array $values Значения для подготовленного выражения
     * @return int
     */
    public function insert($sql, $values = [])
    {
        $stmt = $this->getPrepareStmt($sql, $values);
        mysqli_stmt_execute($stmt);
        $last_id = mysqli_insert_id($this->link);

        if ($last_id > 0) {
            return $last_id;
        } else {
            header('HTTP/1.1 500 Internal Server Error');
            header('Location: /500.php');
        }
    }

    /**
     * Выполняет запрос на перезапись данных
     * @param string $table Имя таблицы
     * @param array $updates Данные для обновления
     * @param array $conditions Поля и их значения в условии WHERE
     * @return int|bool
     */
    public function update($table, $updates, $conditions = [])
    {
        $updatesToString = '';
        $conditionsToString = '';
        $values = [];

        foreach ($updates as $update) {
            foreach ($update as $column => $value) {
                $updatesToString .= "$column = ?, ";
                $values[] = mysqli_real_escape_string($this->link, $value);
            }
        }

        foreach ($conditions as $column => $value) {
            $conditionsToString .= "$column = ? AND ";
            $values[] = $value;
        }

        $updatesToString = substr($updatesToString, 0, -2);
        $conditionsToString = substr($conditionsToString, 0, -5);
        $sql = "UPDATE $table SET $updatesToString WHERE $conditionsToString;";

        $stmt = $this->getPrepareStmt($sql, $values);
        mysqli_stmt_execute($stmt);
        $rows_count = mysqli_stmt_affected_rows($stmt);

        if ($rows_count > 0) {
            return $rows_count;
        } else {
            return false;
        }
    }

    /**
     * Выполняет запрос на удаление записи
     * @param string $table Имя таблицы
     * @param array $conditions Поля и их значения в условии WHERE
     * @return int|bool
     */
    public function delete($table, $conditions = [])
    {
        $values = [];
        $conditionsToString = "";

        foreach ($conditions as $column => $value) {
            $conditionsToString .= "$column = ? AND ";
            $values[] = $value;
        }

        $sql = "DELETE FROM $table WHERE $conditionsToString;";

        $stmt = $this->getPrepareStmt($sql, $values);
        mysqli_stmt_execute($stmt);
        $rows_count = mysqli_stmt_affected_rows($stmt);

        if ($rows_count > 0) {
            return $rows_count;
        } else {
            return false;
        }
    }
}
