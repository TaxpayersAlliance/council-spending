<?php

namespace App\Reports;

use App\Reports\Report;

use Illuminate\Database\Eloquent\Model;

class CouncilTaxHistory extends Report
{
    /**
     * get a formatted name for the model
     * @return [type] [description]
     */
    public function getName()
    {
    	return "Council Tax History";
    }
    /**
     * Concatenates a string for the liabilities content
     * @param [type] $councils [description]
     * @param [type] $type     [description]
     * @param [type] $data     [description]
     */
    public function setContent($council, $data)
    {
        if ($data['real_terms_increase'] != "no data" && $data['real_terms_increase'] >= 0)
        { 
            $concatenatedString = "Council tax charged by " . $council['council'] . " has risen by " . $data['real_terms_increase'] . " in real terms since 1996-97.";
            
            return $concatenatedString;
        }
        if ($data['real_terms_increase'] != "no data" && $data['real_terms_increase'] < 0)
        { 
            $concatenatedString = "Council tax charged by " . $council['council'] . " has fallen by " . abs($data['real_terms_increase']) . " in real terms since 1996-97.";
            
            return $concatenatedString;
        }

        $concatenatedString = "There is no available data for historic council charged by " . $council['council'] . ".";
        
        return $concatenatedString;
    }
}

