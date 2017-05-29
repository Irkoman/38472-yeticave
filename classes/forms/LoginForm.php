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
        ['notEmpty', ['email', 'password']]
    ];

    protected $messages = [];

    /**
     * Полная проверка формы и создание объекта юзера в случае успеха
     */
    public function handleLoginForm()
    {
        if ($this->isSubmitted()) {
            $this->validate();

            if ($this->isValid()) {
                $userModel = new UserModel($this->getFormdata()['email'], $this->getFormdata()['password']);
                $this->errors = $userModel->authErrors;
            }
        }
    }
}
