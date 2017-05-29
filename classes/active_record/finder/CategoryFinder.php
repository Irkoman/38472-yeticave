<?php
namespace yeticave\active_record\finder;

use yeticave\active_record\record\CategoryRecord;

/**
 * Class CategoryFinder
 */
class CategoryFinder extends BaseFinder
{
    /**
     * Поиск всех действующих категорий
     * @return CategoryRecord[] Массив объектов CategoryRecord
     */
    public function findCategories()
    {
        $sql = 'SELECT * FROM category';

        $rows = $this->selectAll($sql);
        $records = [];

        foreach ($rows as $row) {
            $record = new CategoryRecord();
            $records[] = $record->fillRecord($row);
        }

        return $records;
    }
}
