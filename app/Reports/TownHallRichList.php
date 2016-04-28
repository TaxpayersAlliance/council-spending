<?php

namespace App\Reports;

use App\Reports\Report;

use Illuminate\Database\Eloquent\Model;

class TownHallRichList extends Report
{
    /**
     * get a formatted name for the model
     * @return [type] [description]
     */
    public function getName()
    {
    	return "Town Hall Rich List";
    }
    /**
     * Concatenates a string for the liabilities content
     * @param [type] $councils [description]
     * @param [type] $type     [description]
     * @param [type] $data     [description]
     */
    public function setContent($council, $data)
    {
        $concatenatedString = "In the 2014 Town Hall Rich List, " . $council['council'] . " had " . 
            $this->setIndividualTHRLString($data['employees100'], "£100,000") . " and " . 
            $this->setIndividualTHRLString($data['employees150'], "£150,000") . ".";
        
        return $concatenatedString;
    }
    /**
     * sets each individual element of the THRL string
     * @param [type] $value       [description]
     * @param [type] $stringValue [description]
     */
    private function setIndividualTHRLString($value, $stringValue)
    {
        return $value . $this->returnSingularOrPluralString($value, " employee", " employees") . " on more than ". $stringValue;
    }
}
