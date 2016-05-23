<?php
namespace App\Reports;

use App\Reports\Report;

use Illuminate\Database\Eloquent\Model;

class CouncillorsAllowances extends Report
{
    /**
     * get a formatted name for the model
     * @return [type] [description]
     */
    public function getName()
    {
    	return "Councillors Allowances'";
    }
    
    public function setContent($council, $data)
    {
        $concatenatedString = "In 2014-15, " . $council['council'] . " " . 
            $this->basicAllowanceString($data['basic_allowance']) . 
            $this->SRAString($data['special_responsibility_allowance']) . 
            $this->totalAllowanceString($data['total_allowances_cost']) . 
            $this->totalAllowanceAndExpenceString($data['total_allowances_and_expenses_cost']) . " for 2014-15."; 
        
        return $concatenatedString;
    }
    /**
     * set basic allowance portion of content string
     * @param  [type] $value [description]
     * @return [type]        [description]
     */
    private function basicAllowanceString($value)
    {
        if ($value != "no data")
        {
            return "paid a £" . number_format($value) . " basic allowance to councillors. ";
        }
        return "was not able to provide information on the basic allowance paid to councilliors. ";
    }
    /**
     * set SRA part of content string
     * @param [type] $value [description]
     */
    private function SRAString($value)
    {
        if ($value != "no data")
        {
            return "The council leader received an additional £" . number_format($value) . ". ";
        }
        return "No information on the additional allowance paid to the council leader was available. ";
    }
    /**
     * set total allowance cost part of content string
     * @param  [type] $value [description]
     * @return [type]        [description]
     */
    private function totalAllowanceString($value)
    {
        if ($value != "no data")
        {
            return "The total cost of paying the allowances was £" . number_format($value) . ", ";
        }
        return "The total cost of allowances is not known, ";
    }
    /**
     * set total allowances and expenses part of content string
     * @param  [type] $value [description]
     * @return [type]        [description]
     */
    private function totalAllowanceAndExpenceString($value)
    {
        if ($value != "no data")
        {
            return "including expenses, the total cost of paying councillors was £" . number_format($value);
        }
        return "total costs including expenses is not known";
    }
}
