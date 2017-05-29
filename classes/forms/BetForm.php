<?php
namespace yeticave\forms;

use yeticave\models\BetModel;
use yeticave\models\UserModel;
use yeticave\active_record\record\BetRecord;

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
     * Проверка формы и запись ставки в случае успеха
     * @param int $lot_id ID лота, на странице которого происходит действо
     */
    public function handleBetForm($lot_id)
    {
        if ($this->isSubmitted()) {
            $this->validate();

            if ($this->isValid()) {
                $this->createNewBet($lot_id);
            }
        }
    }

    /**
     * Собирает данные для новой записи и отправляет запрос на вставку
     * @param int $lot_id ID лота
     */
    private function createNewBet($lot_id)
    {
        $userModel = new UserModel();
        $userdata = $userModel->getUserdata();
        $my_bets = BetModel::getMyBetsFromCookies();
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
