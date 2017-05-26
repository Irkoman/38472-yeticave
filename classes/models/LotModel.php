<?php
namespace yeticave\models;

use yeticave\ActiveRecord\Finder\LotFinder;
use yeticave\ActiveRecord\Record\LotRecord;

/**
 * Class LotModel
 */
class LotModel extends BaseModel
{
    /**
     * LotModel constructors
     */
    public function __construct()
    {
        $this->finder = new LotFinder();
        $this->record = new LotRecord();
    }
}