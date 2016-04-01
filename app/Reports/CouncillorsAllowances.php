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
    	return "Councillors Allowances";
    }
    
    public function setContent($councils, $type, $data)
    {
        $concatenatedString = "In 2014-15, " .  $councils[$type]['council'] . " " . 
            $this->basicAllowanceString($data['basic_allowance']) . 
            $this->SRAString($data['special_responsibility_allowance']) . 
            $this->totalAllowanceString($data['total_allowances_cost']) . 
            $this->totalAllowanceAndExpenceString($data['total_allowances_and_expenses_cost']); 
        
        return $concatenatedString;
    }
    private function basicAllowanceString($value)
    {
        if ($value != "no data")
        {
            return "paid a £" . number_format($value) . " basic allowance to all councillors. ";
        }
        return "some other string";
    }
    private function SRAString($value)
    {
        if ($value != "no data")
        {
            return "The council leader received an additional £" . number_format($value) . ". ";
        }
        return "some other string";
    }
    private function totalAllowanceString($value)
    {
        if ($value != "no data")
        {
            return "The total cost of paying the allowances was £" . number_format($value) . ", ";
        }
        return "some other string";
    }
    private function totalAllowanceAndExpenceString($value)
    {
        if ($value != "no data")
        {
            return " including expenses, the total cost of paying councillors was £" . number_format($value) . ".";
        }
        return "some other string";
    }
}

// basic_allowance": "12,805",
// "special_responsibility_allowance": "42,109",
// "total_allowances_cost": "1,633,832",
// "total_allowances_and_expenses_cost": "1,747,927",