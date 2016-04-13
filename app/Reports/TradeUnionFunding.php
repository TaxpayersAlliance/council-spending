<?php

namespace App\Reports;

use App\Reports\Report;

use Illuminate\Database\Eloquent\Model;

class TradeUnionFunding extends Report
{
    /**
     * get a formatted name for the model
     * @return [type] [description]
     */
    public function getName()
    {
    	return "Taxpayer Funded Trade Unions";
    }
    /**
     * Concatenates a string for the liabilities content
     * @param [type] $councils [description]
     * @param [type] $type     [description]
     * @param [type] $data     [description]
     */
    public function setContent($council, $data)
    {
        $concatenatedString = "In 2012-13 " . $council . $this->unionFundingString($data['union_funding']) . $this->unionFTEString($data['staff_fte']);
        
        return $concatenatedString;
    }
    /**
     * sets the union funding element of the string
     * @param  [type] $value [description]
     * @return [type]        [description]
     */
        private function unionFundingString($value)
    {
        if ($value != "no data")
        {
            return " paid £" . number_format($value) . " directly to unions. ";
        }
        return " was not able to provide information on payments to unions. ";
    }
    /**
     * sets the staff FTE element of the string
     * @param  [type] $value [description]
     * @return [type]        [description]
     */
    private function unionFTEString($value)
    {
        if ($value != "no data")
        {
            return "The equivalent of " . $value . " worked full time on union duties";
        }
        return "No information on the additional allowance paid to the council leader was available. ";
    }
}

