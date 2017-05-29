<?php
namespace yeticave\forms;

use yeticave\models\UserModel;
use yeticave\active_record\record\LotRecord;

/**
 * Class LotForm
 */
class LotForm extends BaseForm
{
    public $formName = 'lot';

    protected $fields = ['lot-date', 'category', 'lot-name', 'message', 'lot-file', 'lot-rate', 'lot-step'];

    protected $rules = [
        ['numeric', ['lot-rate', 'lot-step']],
        ['date', ['lot-date']],
        ['image', ['lot-file']],
        ['notEmpty', ['lot-date', 'category', 'lot-name', 'message', 'lot-file', 'lot-rate', 'lot-step']]
    ];

    /**
     * Полная проверка формы и добавление нового лота в случае успеха
     */
    public function handleLotForm()
    {
        if ($this->isSubmitted()) {
            $this->validate();
            $this->saveImage('lot-file');

            if ($this->isValid()) {
                $this->createNewLot();
            }
        }
    }

    /**
     * Собирает данные для новой лота и отправляет запрос на вставку
     */
    private function createNewLot()
    {
        $userModel = new UserModel();
        $formdata = $this->getFormdata();

        $lotRecord = new LotRecord();
        $lotRecord->date_add = date('Y-m-d H:i:s');
        $lotRecord->date_close = date('Y-m-d H:i:s', strtotime($formdata['lot-date']));
        $lotRecord->category_id = $formdata['category'];
        $lotRecord->user_id = $userModel->getUserdata()['id'];
        $lotRecord->title = $formdata['lot-name'];
        $lotRecord->description = $formdata['message'];
        $lotRecord->image = 'img/upload/' . $formdata['lot-file']['name'];
        $lotRecord->initial_rate = $formdata['lot-rate'];
        $lotRecord->rate_step = $formdata['lot-step'];
        $lotRecord->fav_count = 0;
        $lotRecord->insert();

        header('Location: /lot.php?id=' . $lotRecord->id);
    }
}
