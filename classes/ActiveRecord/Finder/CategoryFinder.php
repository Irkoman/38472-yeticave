<?php
namespace yeticave\ActiveRecord\Finder;

use yeticave\ActiveRecord\Record\CategoryRecord;

/**
 * Class CategoryFinder
 */
class CategoryFinder extends BaseFinder
{
    protected $tableName = 'category';

    /**
     * Поиск всех действующих категорий
     * @return CategoryRecord[] Массив объектов CategoryRecord
     */
    public function findCategories()
    {
        $sql = "SELECT * FROM category";

        $rows = parent::selectAll($sql);
        $records = [];

        foreach ($rows as $row) {
            $record = new CategoryRecord();
            $records[] = $record->fillRecord($row);
        }

        return $records;
    }
}
