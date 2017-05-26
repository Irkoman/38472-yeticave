<?php
namespace yeticave\forms;

use yeticave\services\Database;
use yeticave\ActiveRecord\Record\UserRecord;

/**
 * Class SignupForm
 */
class SignupForm extends BaseForm
{
    public $formName = 'signup';

    protected $fields = ['email', 'password', 'name', 'message', 'avatar'];

    protected $rules = [
        ['email', ['email']],
        ['image', 'avatar'],
        ['required', ['email', 'password', 'name', 'message']],
    ];

    /**
     * Полная проверка формы и регистрация нового пользователя в случае успеха
     */
    public function checkSignupForm()
    {
        $avatar = '';

        if ($this->isSubmitted()) {
            $this->validate();
            $formdata = $this->getFormdata();
            $database = new Database();

            if (!empty($formdata['email']) && $database->searchUserByEmail($formdata['email'])) {
                $this->errors['email'] = 'Указанный email уже используется другим пользователем';
            }

            if (!empty($formdata['avatar']['name'])) {
                $avatar = 'img/upload/' . $formdata['avatar']['name'];
            }

            if ($this->isValid()) {
                $userRecord = new UserRecord();
                $userRecord->date_add = date('Y-m-d H:i:s');
                $userRecord->email = $formdata['email'];
                $userRecord->password = password_hash($formdata['password'], PASSWORD_DEFAULT);
                $userRecord->name = $formdata['name'];
                $userRecord->avatar = $avatar;
                $userRecord->contact = $formdata['message'];
                $userRecord->insert();

                header('Location: /');
            }
        }
    }

    /**
     * Проверяет email на корректность
     * @param array $fields Список полей для проверки
     * @return bool Результат проверки
     */
    protected function runEmailValidator($fields)
    {
        $result = true;

        foreach ($fields as $value) {
            $field = $this->formData[$value];

            if (!filter_var($field, FILTER_VALIDATE_EMAIL)) {
                $result = false;

                $this->errors[$value] = 'Введите корректный email';
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
    protected function runImageValidator($field, $allowed_mime = '')
    {
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
                move_uploaded_file($file['tmp_name'], 'img/upload/' . $file['name']);
            } else {
                $this->errors[$field] = 'Допустимые форматы изображений: jpeg, png, gif, tiff';
            }
        }

        return $result;
    }
}
