<?php

/**
 * Class BetModel
 */
class BetModel extends BaseModel
{
    /**
     * @var string $name Будет использоваться конструктором
     */
    protected $name = 'Bet';

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