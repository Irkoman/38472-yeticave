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
        ['notEmpty', ['email', 'password', 'name', 'message']],
        ['image', ['avatar']]
    ];

    /**
     * Полная проверка формы и регистрация нового пользователя в случае успеха
     */
    public function checkSignupForm()
    {
        if ($this->isSubmitted()) {
            $this->validate();
            $this->saveImage('avatar');
            $formdata = $this->getFormdata();
            $database = new Database();
            $avatar = '';

            if (!empty($formdata['email']) && $database->searchUserByEmail($formdata['email'])) {
                $this->errors['email'] = 'Указанный email уже используется другим пользователем';
            }

            if (empty($formdata['avatar']['name'])) {
                unset($this->errors['avatar']);
            } else {
                $avatar =  'img/upload/' . $formdata['avatar']['name'];
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
}
