<?php
namespace yeticave\models;

use yeticave\active_record\finder\BetFinder;
use yeticave\active_record\record\BetRecord;

/**
 * Class BetModel
 */
class BetModel extends BaseModel
{
    /**
     * BetModel constructor
     */
    public function __construct()
    {
        $this->finder = new BetFinder();
        $this->record = new BetRecord();
    }

    /**
     * @return array Ставки пользователя, найденные в куках
     */
    public static function getMyBetsFromCookies()
    {
        $my_bets = [];

        if (isset($_COOKIE['my_bets'])) {
            $my_bets = json_decode($_COOKIE['my_bets'], true);
        }

        return $my_bets;
    }

    /**
     * @return bool Проверяет, делал ли юзер ставку на определённый лот
     */
    public static function isAlreadyBetted($lot_id, $my_bets)
    {
        foreach ($my_bets as $my_bet) {
            if ($lot_id == $my_bet['lot_id']) {
                return true;
            }
        }

        return false;
    }
}