<?php

/**
 * Class LoginForm
 */
class LoginForm extends BaseForm {

  public $formName = 'login';

  protected $fields = ['email', 'password'];

  protected $rules = [
    ['email', ['email']],
    ['required', ['email', 'password']],
  ];

  /**
   * Проверяет email на корректность
   * @param array $fields Список полей для проверки
   * @return bool Результат проверки
   */
  protected function runEmailValidator($fields) {
    $result = true;

    foreach ($fields as $value) {
      $field = $this->formData[$value];

      if (!filter_var($field, FILTER_VALIDATE_EMAIL)) {
        $result = false;

        $this->errors[$value] = "Введите корректный email";
      }
    }

    return $result;
  }
}
