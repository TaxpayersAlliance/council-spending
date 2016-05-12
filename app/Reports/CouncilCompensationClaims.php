<?php

namespace App\Reports;

use App\Reports\Report;
use Illuminate\Database\Eloquent\Model;

class CouncilCompensationClaims extends Report
{
    /**
     * get a formatted name for the model
     * @return [type] [description]
     */
    public function getName()
    {
    	return "Council Compensation Claims";
    }
    /**
     * concatenate a string for the 'content' field from the data in the model
     * 
     * @param [type] $councils [description]
     * @param [type] $type     [description]
     * @param [type] $data     [description]
     */
    public function setContent($council, $data)
    {
        $concatenatedString = $council['council'] . $this->totalCost($data['total']);
        
        return $concatenatedString;
    }
    /**
     * [totalNumberString description]
     * @param  [type] $value [description]
     * @return [type]        [description]
     */
    private function totalCost($value)
    {
        if ($value != "no data")
        {
            return " paid out a total of £" . number_format($value) . " in compensation between 2013 and 2015.";
        }
        return " was not able to provide information on compensation claims paid between 2013 and 2015.";
    }
}
