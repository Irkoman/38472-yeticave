<?php
namespace yeticave\forms;

use yeticave\models\BetModel;
use yeticave\models\UserModel;
use yeticave\ActiveRecord\Record\BetRecord;

/**
 * Class BetForm
 */
class BetForm extends BaseForm
{
    public $formName = 'bet';

    protected $fields = ['cost'];

    protected $rules = [
        ['notEmpty', ['cost']],
        ['numeric', ['cost']]
    ];

    /**
     * Полная проверка формы и запись ставки в случае успеха
     * @param int $lot_id ID лота, на странице которого происходит действо
     */
    public function checkBetForm($lot_id)
    {
        $userModel = new UserModel();
        $userdata = $userModel->getUserdata();
        $my_bets = BetModel::getMyBetsFromCookies();

        if ($this->isSubmitted()) {
            $this->validate();

            if ($this->isValid()) {
                $formdata = $this->getFormdata();

                $my_bets[] = [
                    'date_add' => time(),
                    'lot_id' => $lot_id,
                    'rate' => $formdata['cost']
                ];

                setcookie('my_bets', json_encode($my_bets), strtotime('+1 month'));

                $betRecord = new BetRecord();
                $betRecord->date_add = date('Y-m-d H:i:s');
                $betRecord->lot_id = $lot_id;
                $betRecord->user_id = $userdata['id'];
                $betRecord->rate = $formdata['cost'];
                $betRecord->insert();

                header('Location: /mylots.php');
            }
        }
    }
}
