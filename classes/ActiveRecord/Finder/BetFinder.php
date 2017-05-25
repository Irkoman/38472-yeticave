<?php

/**
 * Class BetFinder
 */
class BetFinder extends BaseFinder
{
    protected $tableName = 'bet';

    /**
     * Поиск ставок для лота по его id
     * @param int $id
     * @return BetRecord[] Массив объектов класса BetRecord
     */
    public function findBetsByLot($id)
    {
        $sql = 'SELECT bet.date_add, bet.rate, user.name AS user_name
                FROM bet JOIN user ON bet.user_id = user.id
                WHERE bet.lot_id = ? ORDER BY bet.date_add DESC LIMIT 5';

        return parent::selectAll($sql, 'BetRecord', [$id]);
    }

    /**
     * Поиск ставок, сделанных одним пользователем
     * @param int $id
     * @return BetRecord[] Массив объектов класса BetRecord
     */
    public function findBetsByUser($id)
    {
        $sql = 'SELECT bet.lot_id, bet.date_add, bet.rate, lot.title AS lot_title, lot.image AS lot_image, lot.date_close AS lot_date_close, category.name AS category_name
                FROM bet JOIN lot ON lot.id = bet.lot_id JOIN category ON category.id = lot.category_id
                WHERE bet.user_id = ?';

        return parent::selectAll($sql, 'BetRecord', [$id]);
    }
}
