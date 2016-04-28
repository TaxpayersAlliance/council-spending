<?php

namespace App\Reports;

use App\Reports;
use Illuminate\Database\Eloquent\Model;

class CouncilArt extends Report
{
    /**
     * get a formatted name for the model
     * @return [type] [description]
     */
    public function getName()
    {
    	return "Government Art";
    }
    /**
     * concatenate a string for the 'content' field from the data in the model
     * 
     * @param  [type] $councils       [description]
     * @param  [type] $type           [description]
     * @param  [type] $councilArtData [description]
     * @return [type]                 [description]
     */
    public function setContent($council, $data)
    {
        $strTotalNumber = $this->totalNumberString($data['total_number']);

        $strOnDisplay = $this->totalOnDisplayString($data['total_on_display']);
        
        $strValue = $this->totalValueString($data['value']);

        $concatenatedString = $council['council'] . $strTotalNumber . $strOnDisplay . $strValue;

        return $concatenatedString;
    }
    /**
     * concatenate the string for the total number of art works
     * @param  [type] $value [description]
     * @return [type]        [description]
     */
    private function totalNumberString($value)
    {
        if ($value != "No data")
        {
            return " had " . number_format($value) . $this->returnSingularOrPluralString($value, " item", " items") . " of art. ";
        }
        return " was not able to provide information on how many works of art it held. ";
    }
    /**
     * concatenate the string for the number on display
     * @param  [type] $value [description]
     * @return [type]        [description]
     */
    private function totalOnDisplayString($value)
    {
        if ($value != "No data")
        {
            return number_format($value) . " items are on display. ";
        } 
        return "It is not known how many works are on display. ";
    }
    /**
     * concatenate the string for the value of the art
     * @param  [type] $value [description]
     * @return [type]        [description]
     */
    private function totalValueString($value)
    {
        if ($value != "No data")
        {
            return "The value of the work is £" . number_format($value);
        } 
        return "The value of the work is not known.";
    }
}
