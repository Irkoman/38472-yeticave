<?php
namespace yeticave\models;

use yeticave\active_record\finder\LotFinder;
use yeticave\active_record\record\LotRecord;

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