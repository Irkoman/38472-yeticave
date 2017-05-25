<?php

/**
 * Class LotFinder
 */
class LotFinder extends BaseFinder
{
    protected $tableName = 'lot';

    /**
     * Поиск по лотам и смежным таблицам
     * @param int $id
     * @return LotRecord Объект класса LotRecord
     */
    public function findLotById($id)
    {
        $sql = 'SELECT lot.id, lot.title, lot.description, lot.initial_rate, lot.image, lot.date_close, category.name AS category_name
                FROM lot JOIN category ON lot.category_id = category.id WHERE lot.id = ?';

        return parent::selectOne($sql, 'LotRecord', [$id]);
    }

    /**
     * Поиск актуальных лотов
     * @return LotRecord[] Массив объектов класса LotRecord
     */
    public function findActualLots()
    {
        $sql = 'SELECT lot.id, lot.title, lot.initial_rate, lot.image, lot.date_close, category.name AS category_name
                FROM lot JOIN category ON lot.category_id = category.id
                WHERE lot.date_close > NOW() AND lot.winner_id IS NULL
                ORDER BY lot.date_add DESC LIMIT 6';

        return parent::selectAll($sql, 'LotRecord');
    }
}