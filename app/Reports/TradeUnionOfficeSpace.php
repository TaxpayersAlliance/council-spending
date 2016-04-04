<?php

namespace App\Reports;

use App\Reports\Report;

use Illuminate\Database\Eloquent\Model;

class TradeUnionOfficeSpace extends Report
{
    /**
     * get a formatted name for the model
     * @return [type] [description]
     */
    public function getName()
    {
    	return "Trade Union Office Space";
    }
    /**
     *  Concatenates a string for the liabilities content
     * @param [type] $councils [description]
     * @param [type] $type     [description]
     * @param [type] $data     [description]
     */
    public function setContent($councils, $type, $data)
    {
        $concatenatedString = "The Trade Union Office Space paper found that " . $councils[$type]['council'] . $this->floorSpaceString($data['floor_space']) . $this->valuationString($data['valuation']);
        
        return $concatenatedString;
    }
    /**
     * sets the floor space element of the content string
     * @param  [type] $value [description]
     * @return [type]        [description]
     */
    private function floorSpaceString($value)
    {
        if ($value != "no data")
        {
            return " gave trade unions use of " . number_format($value) . " square foot of office space. ";
        }
        return "was not able to provide information on the amount of office space used for trade union activities. ";
    }
    /**
     * sets the office valuation element of the content string
     * @param  [type] $value [description]
     * @return [type]        [description]
     */
    private function valuationString($value)
    {
        if ($value != "no data")
        {
            return "The value of this space was £" . number_format($value) . ". ";
        }
        return "No information was available about the value of the space. ";
    }
}

// unit for floor space is square feet