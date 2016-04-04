<?php

namespace App\Reports;

use App\Reports\Report;

use Illuminate\Database\Eloquent\Model;

class CouncilLiabilities extends Report
{
    /**
     * get a formatted name for the model
     * @return [type] [description]
     */
    public function getName()
    {
    	return "Council Liabilities";
    }
    /**
     * concatenate a string for the 'content' field from the data in the model
     * 
     * @param [type] $councils [description]
     * @param [type] $type     [description]
     * @param [type] $data     [description]
     */
    public function setContent($councils, $type, $data)
    {
        return $concatenatedString = $councils[$type]["council"] . $this->liabilitiesString($data);


    }
    /**
     * Concatenates a string for the liabilities content
     * @param  [type] $value [description]
     * @return [type]        [description]
     */
    private function liabilitiesString($value)
    {
        if($value != "no data")
        {
            $liabilitiesTotal =  " had total liabilities of £" . number_format($value['liabilities_total']) . ", ";

            $liabilitiesPerPerson = $this->liabilitiesPerPersonString($value['liabilities_per_person']);

            $liabilitiesPercentage = $this->liabilitiesPercentageString($value['liabilities_as_percentage_of_assets']);

            $concatenatedString = $liabilitiesTotal . $liabilitiesPerPerson . $liabilitiesPercentage;

            return $concatenatedString;
        }
        return " was not able to provide information about its liabilities";
    }
    /**
     * provides the liabilities per person part of the liabilities string
     * @param  [type] $value [description]
     * @return [type]        [description]
     */
    private function liabilitiesPerPersonString($value)
    {
        if($value != "no data")
        {
            return "which is equivalent to £" . number_format($value) . " per person, ";
        }
        return "";
    }
    /**
     * provides the liabilities as a percentage of total assets part of the liabilities string
     * @param  [type] $value [description]
     * @return [type]        [description]
     */
    private function liabilitiesPercentageString($value)
    {
        if($value != "no data")
        {
            return " or " . $value . "% of the council's assets";
        }
        return "";
    }
}
