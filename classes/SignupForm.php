<?php

/**
 * Class SignupForm
 */
class SignupForm extends BaseForm {

  public $formName = 'signup';

  protected $fields = ['email', 'password', 'name', 'message', 'avatar'];

  protected $rules = [
    ['email', ['email']],
    ['image', 'avatar'],
    ['required', ['email', 'password', 'name', 'message']],
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

  /**
   * Проверяет, что загруженный файл является изображением
   * @param string $field Полe с изображением
   * @param string $allowed_mime Допустимые mime_type
   * @return bool Результат проверки
   */
  protected function runImageValidator($field, $allowed_mime = '') {
    $result = true;

    if (!empty($_FILES)) {
      $allowed_types = ['image/jpeg', 'image/png', 'image/gif', 'image/tiff'];

      if ($allowed_mime) {
        $allowed_types = [$allowed_mime];
      }

      $file = $_FILES[$field];

      if ($file['tmp_name']) {
        $fileinfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_file($fileinfo, $file['tmp_name']);
        $result = in_array($mime, $allowed_types);
      }

      if ($result) {
        move_uploaded_file($file['tmp_name'], 'img/' . $file['name']);
      } else {
        $this->errors[$field] = 'Допустимые форматы изображений: jpeg, png, gif, tiff';
      }
    }

    return $result;
  }
}
