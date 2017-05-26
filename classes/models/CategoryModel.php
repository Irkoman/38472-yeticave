<?php
namespace yeticave\models;

use yeticave\ActiveRecord\Finder\CategoryFinder;
use yeticave\ActiveRecord\Record\CategoryRecord;

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
