<?php
namespace yeticave\forms;

use Respect\Validation\Validator as v;

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
     * @var array $validators Набор валидаторов,
     * позаимствованных из библиотеки Respect\Validation
     */
    public $validators = [];

    /**
     * @var array $errors Список ошибок валидации
     */
    protected $errors = [];

    /**
     * @var array $rules Список правил валидации для конкретной формы
     */
    protected $rules = [];

    /**
     * @var array $messages Тексты ошибок
     */
    protected $messages = [];

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
        $this->initValidators();
        $this->initMessages();
    }

    /**
     * Инициализация списка валидаторов
     * @return void
     */
    public function initValidators()
    {
        $this->validators['notEmpty'] = v::notEmpty();
        $this->validators['numeric']  = v::numeric()->positive();
        $this->validators['date']     = v::date('d.m.Y');
        $this->validators['email']    = v::email();
        $this->validators['image']    = v::image();
    }

    /**
     * Инициализация списка кастомных сообщений об ошибках
     * @return void
     */
    public function initMessages()
    {
        $this->messages = [
            'notEmpty' => 'Заполните это поле',
            'numeric'  => 'Здесь должно быть число',
            'email'    => 'Введите корректный email',
            'date'     => 'Некорректная дата',
            'image'    => 'Допустимые форматы изображений: jpeg, png, gif, tiff',
        ];
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
     * Заполняет formData данными из формы
     * @param array $data Данные для заполнения
     */
    protected function fillFormData($data = [])
    {
        if (!$this->isSubmitted()) {
            return;
        }

        $fillData = !empty($data) ? $data : array_merge($_POST, $_FILES);

        foreach ($this->fields as $field) {
            $this->formData[$field] = array_key_exists($field, $fillData) ? $fillData[$field] : null;
        }
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
     * Возвращает текст ошибки для конкретного поля
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
     * Сохраняет в папку upload загруженное пользователем
     * и успешно прошедшее валидацию изображение
     * @param string $field_name Имя поля с изображением
     * @return void
     */
    public function saveImage($field_name)
    {
        if (empty($this->errors[$field_name]) && !empty($_FILES[$field_name])) {
            $file = $_FILES[$field_name];
            move_uploaded_file($file['tmp_name'], 'img/upload/' . $file['name']);
        }
    }

    /**
     * Запускает валидатор по его имени
     * @param string $name Имя валидатора
     * @return array $fields Список имён полей для валидации
     */
    protected function runValidator($name, $fields)
    {
        foreach ($fields as $field){
            $validator = $this->validators[$name];
            $fieldToValidate = !empty($_FILES[$field]['tmp_name']) ? $this->formData[$field]['tmp_name'] : $this->formData[$field];

            if (!$validator->validate($fieldToValidate)) {
                $this->errors[$field] = $this->messages[$name];
            }
        }
    }
}
