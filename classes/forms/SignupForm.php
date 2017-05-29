<?php
namespace yeticave\forms;

use yeticave\active_record\finder\UserFinder;
use yeticave\active_record\record\UserRecord;

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
    public function handleSignupForm()
    {
        if ($this->isSubmitted()) {
            $this->validate();
            $this->saveImage('avatar');
            $formdata = $this->getFormdata();
            $userFinder = new UserFinder();
            $avatar = '';

            if (!empty($formdata['email']) && $userFinder->findUserByEmail($formdata['email'])) {
                $this->errors['email'] = 'Указанный email уже используется другим пользователем';
            }

            if (empty($formdata['avatar']['name'])) {
                unset($this->errors['avatar']);
            } else {
                $avatar =  'img/upload/' . $formdata['avatar']['name'];
            }

            if ($this->isValid()) {
                $this->createNewUser($formdata, $avatar);
            }
        }
    }

    /**
     * Создаёт запись для нового пользователя и отправляет запрос на вставку
     * @param array $formdata Данные, полученные из формы
     * @param string $avatar Аватар
     */
    private function createNewUser($formdata, $avatar)
    {
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
