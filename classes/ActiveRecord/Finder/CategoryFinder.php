<?php

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

        return parent::selectAll($sql, 'CategoryRecord');
    }
}
