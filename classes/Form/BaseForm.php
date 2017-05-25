<?php

/**
 * Class BaseForm
 */
abstract class BaseForm
{
    /**
     * @var string $formName Имя формы
     */
    public $formName;

    /**
     * @var array $fields Список полей формы
     */
    protected $fields = [];

    /**
     * @var array $errors Список ошибок валидации
     */
    protected $errors = [];

    /**
     * @var array $rules Список правил валидации
     */
    protected $rules = [];

    /**
     * @var array $formData Отправленные данные
     */
    protected $formData = [];

    /**
     * BaseForm constructor
     * @param array $data Данные формы
     */
    public function __construct($data = [])
    {
        $this->fillFormData($data);
    }

    /**
     * Проверяет, что форма была отправлена
     * @return bool
     */
    public function isSubmitted()
    {
        return !empty($_POST);
    }

    /**
     * Проверка на валидность
     * @return bool
     */
    public function isValid()
    {
        return count($this->errors) == 0;
    }

    /**
     * Возвращает данные, отправленные из формы
     * @return array
     */
    public function getFormData()
    {
        return $this->formData;
    }

    /**
     * Возвращает текст ошибки для поля
     * @param string $field Имя поля
     * @return string|null Текст ошибки
     */
    public function getError($field)
    {
        return $this->errors[$field] ?? null;
    }

    /**
     * Возвращает список всех ошибок
     * @return array
     */
    public function getAllErrors()
    {
        return $this->errors;
    }

    /**
     * Выполняет валидацию формы
     * @return void
     */
    public function validate()
    {
        foreach ($this->rules as $rule) {
            list($rulename, $fields) = $rule;

            $this->runValidator($rulename, $fields);
        }
    }

    /**
     * Магический метод для получения значения поля по его имени
     * @param string $name Имя поля
     * @return mixed|null
     */
    public function __get($name)
    {
        $result = $this->formData[$name] ?? null;

        return $result;
    }

    /**
     * Запускает валидатор по его имени
     * @param string $name Имя валидатора
     * @return array $fields Список имён полей для валидации
     */
    protected function runValidator($name, $fields)
    {
        $method_name = 'run' . ucfirst($name) . 'Validator';

        if (method_exists($this, $method_name)) {
            $this->$method_name($fields);
        }
    }

    /**
     * Проверяет поля на заполненность
     * @param array $fields Поля для проверки
     * @return bool Результат проверки
     */
    protected function runRequiredValidator($fields)
    {
        $result = true;

        foreach ($fields as $key => $value) {
            if (!$this->formData[$value]) {
                $result = false;

                $this->errors[$value] = 'Заполните это поле';
            }
        }

        return $result;
    }

    /**
     * Заполняет formData данными из формы
     * @param array $data Данные для заполнения
     */
    private function fillFormData($data = [])
    {
        if (!$this->isSubmitted()) {
            return;
        }

        $fillData = !empty($data) ? $data : array_merge($_POST, $_FILES);

        foreach ($this->fields as $field) {
            $this->formData[$field] = array_key_exists($field, $fillData) ? $fillData[$field] : null;
        }
    }
}
