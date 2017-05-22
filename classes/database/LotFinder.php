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
        $row = [];
        $sql = "SELECT lot.id, lot.title, lot.description, lot.initial_rate, lot.image, category.name AS category
                FROM lot JOIN category ON lot.category_id = category.id WHERE lot.id = $id";
        $row = $this->database->select($sql)[0];
        return $row;
//        return new LotRecord($this->database, 'lot');
    }
}
