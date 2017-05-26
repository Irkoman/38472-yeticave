<?php
namespace yeticave\forms;

use yeticave\models\UserModel;

/**
 * Class LoginForm
 */
class LoginForm extends BaseForm
{
    public $formName = 'login';

    protected $fields = ['email', 'password'];

    protected $rules = [
        ['email', ['email']],
        ['required', ['email', 'password']],
    ];

    /**
     * Полная проверка формы и создание объекта юзера в случае успеха
     */
    public function checkLoginForm()
    {
        if ($this->isSubmitted()) {
            $this->validate();

            if ($this->isValid()) {
                $userModel = new UserModel($this->getFormdata()['email'], $this->getFormdata()['password']);
                $this->errors = $userModel->authErrors;
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
}
