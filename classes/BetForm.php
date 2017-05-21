<?php

/**
 * Class BetForm
 */
class BetForm extends BaseForm {

  public $formName = 'bet';

  protected $fields = ['cost'];

  protected $rules = [
    ['number', ['cost']],
    ['required', ['cost']],
  ];

  /**
   * Проверяет числовые поля на корректность
   * @param array $fields Список полей для проверки
   * @return bool Результат проверки
   */
  protected function runNumberValidator($fields) {
    $result = true;

    foreach ($fields as $value) {
      $field = $this->formData[$value];

      if (!filter_var($field, FILTER_VALIDATE_INT)) {
        $result = false;

        $this->errors[$value] = "Здесь должно быть число";
      }
    }

    return $result;
  }
}
