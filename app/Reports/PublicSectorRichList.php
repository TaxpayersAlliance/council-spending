<?php

namespace App\Reports;

use App\Reports\Report;

use Illuminate\Database\Eloquent\Model;

class PublicSectorRichList extends Report
{
    /**
     * get a formatted name for the model
     * @return [type] [description]
     */
    public function getName()
    {
    	return "Public Sector Rich List";
    }
    /**
     * Concatenates a string for the liabilities content
     * @param [type] $councils [description]
     * @param [type] $type     [description]
     * @param [type] $data     [description]
     */
    public function setContent($council, $data)
    {
        $concatenatedString = "In the 2015 Public Sector Rich List, ". $council['council'] . " had " . 
            $this->setIndividualPSRLStrings($data['employees100'], "£100,000") . ", " . 
            $this->setIndividualPSRLStrings($data['employees150'], "£150,000") . ", " . 
            $this->setIndividualPSRLStrings($data['employees200'], "£200,000") . " and " . 
            $this->setIndividualPSRLStrings($data['employees300'], "£300,000") . ". ";
        
        return $concatenatedString;
    }
    /**
     * Sets each individual portion of the PSRL content string
     * @param [type] $value       [description]
     * @param [type] $stringValue [description]
     */
    private function setIndividualPSRLStrings($value, $stringValue)
    {
        return $value . $this->returnSingularOrPluralString($value, " employee", " employees") . " on more than ". $stringValue;
    }
}
