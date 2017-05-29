<?php
namespace yeticave\active_record\finder;

use yeticave\active_record\record\LotRecord;

/**
 * Class LotFinder
 */
class LotFinder extends BaseFinder
{
    /**
     * Поиск по лотам и смежным таблицам
     * @param int $id
     * @return LotRecord|bool Объект класса LotRecord
     */
    public function findLotById($id)
    {
        $sql = 'SELECT lot.id, lot.title, lot.description, lot.initial_rate, lot.image, lot.date_close, category.name AS category_name
                FROM lot JOIN category ON lot.category_id = category.id WHERE lot.id = ?';

        $row = $this->selectOne($sql, [$id]);

        if ($row) {
            $record = new LotRecord();
            return $record->fillRecord($row);
        }

        return false;
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

        $rows = $this->selectAll($sql);
        $records = [];

        foreach ($rows as $row) {
            $record = new LotRecord();
            $records[] = $record->fillRecord($row);
        }

        return $records;
    }
}