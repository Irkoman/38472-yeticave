<?php
namespace yeticave\models;

use yeticave\active_record\finder\CategoryFinder;
use yeticave\active_record\record\CategoryRecord;

/**
 * Class CategoryModel
 */
class CategoryModel extends BaseModel
{
    /**
     * CategoryModel constructor
     */
    public function __construct()
    {
        $this->finder = new CategoryFinder();
        $this->record = new CategoryRecord();
    }
}
